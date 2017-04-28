<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Nuvemshop;
use App\Bibliomundi;
use App\Product;
use App\Productmapping;
use App\Categorymapping;
use TiendaNube;

/**
 * Class IntergrateController
 * @package App\Http\Controllers
 */
class IntergrateController extends Controller
{
    public $setting;
    public $lang;
    public $shop;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->lang = 'pt';
        $this->request = $request;
        foreach (Setting::get() as $setting) {
            $this->setting[$setting->key] = $setting->value;
        }        
    }

    public function delcategory($id)
    {
        $this->shop = Nuvemshop::where('id', '=', $id)->first();
        if($this->shop->access_token){
            $api = new \TiendaNube\API($this->shop->tiendanube_id, $this->shop->access_token, 'Bibliomundi');

            $categories = Categorymapping::where('tiendanube_id', '=', $this->shop->tiendanube_id)->get();
            foreach ($categories as $category) {        
                $api->delete("categories/".$category->nuvem_id_category);
                Categorymapping::where('nuvem_id_category', '=', $category->nuvem_id_category)->delete();
            }            
        }
    }

    public function getprocess()
    {
        echo file_get_contents(storage_path().'/logs/import.lock');
        die;
    }    

    public function syncprod($id)
    {
        $this->shop = Nuvemshop::where('id', '=', $id)->first();
        $bbm = new Bibliomundi($this->setting);
        $catalog = $bbm->getCatalog();
        set_time_limit(0);//Avoids timeout, considering there will be a number of operations
        $parser = new \BBMParser\OnixParser($catalog);    

        if(!$productsAvailable = $parser->getOnix()->getProductsAvailable())
            throw new Exception("There are no ebooks to import!");

        $lock = fopen(storage_path().'/logs/import.lock', 'a');
        ftruncate($lock, 0);
        fwrite($lock, json_encode(['status' => 'progress', 'current' => str_pad($count = 0, 2, 0, STR_PAD_LEFT), 'total' => str_pad(count($productsAvailable), 2, 0, STR_PAD_LEFT)]));
        fclose($lock);
        
        if($this->shop->access_token){
            $api = new \TiendaNube\API($this->shop->tiendanube_id, $this->shop->access_token, 'Bibliomundi');
            
            //Be it Complete or Update, it will all be here!    
            foreach($productsAvailable as $bbmProduct){

                $lock = fopen(storage_path().'/logs/import.lock', 'a');
                ftruncate($lock, 0);
                fwrite($lock, json_encode(['status' => 'progress', 'current' => str_pad(++$count, 2, 0, STR_PAD_LEFT), 'total' => str_pad(count($productsAvailable), 2, 0, STR_PAD_LEFT)]));
                fclose($lock);

                //get product_mapping
                $bbm_id_product = $bbmProduct->getId();
                $idProductAlreadyInserted = Productmapping::where('tiendanube_id', '=', $this->shop->tiendanube_id)->where('bbm_id_product', '=', $bbm_id_product)->value('nuvem_id_product');
                $product = new Product($bbmProduct);

                //Avoids duplicated entries
                if($idProductAlreadyInserted && $bbmProduct->getOperationType() == '03') //insert
                    continue;                            

                //In case the process of Updated includes the Deletion of a Product
                if($bbmProduct->getOperationType() == '05'){ //delete
                    if($idProductAlreadyInserted){
                        //call api delete product on Nuvem
                        $api->delete("products/".$idProductAlreadyInserted);
                        //delete product on mapping table
                         Productmapping::where('tiendanube_id', '=', $this->shop->tiendanube_id)->where('bbm_id_product', '=', $bbm_id_product)->delete();
                        continue;//Moves on to next ebook
                    }
                    else
                        continue;
                }
                
                //Topics (Categories)
                if(count($bbmProduct->getCategories())){
                    $categoriesIds = [];
                    foreach ($bbmProduct->getCategories() as $bbmCategory){
                        $bbm_id_category = $bbmCategory->getCode();
                        $idCategoryAlreadyInserted = Categorymapping::where('tiendanube_id', '=', $this->shop->tiendanube_id)->where('bbm_id_category', '=', $bbm_id_category)->value('nuvem_id_category');
                        if(!$idCategoryAlreadyInserted){
                            //call api create category
                            $category = [
                                'name' => [$this->lang => $bbmCategory->getName()]
                            ];
                            $response = $api->post("categories", $category);
                            if($response instanceof \TiendaNube\API\Response){                                
                                //add to category mapping
                                Categorymapping::insert(['tiendanube_id' => $this->shop->tiendanube_id, 'bbm_id_category' => $bbm_id_category, 'nuvem_id_category' => $response->body->id]);
                                $categoriesIds[] = $response->body->id;
                            }                            
                        }else
                            $categoriesIds[] = $idCategoryAlreadyInserted;
                    }
                } 

                if($idProductAlreadyInserted && $bbmProduct->getOperationType() == '04'){ //update
                    //call api update product
                    $product->setID($idProductAlreadyInserted);
                    $response = $api->put("products", $product);
                }

                if(!$idProductAlreadyInserted && $bbmProduct->getOperationType() == '03'){ //insert
                    //call api create product
                    $product->categories = $categoriesIds;
                    $response = $api->post("products", $product);
                    if($response instanceof \TiendaNube\API\Response){                                
                        //add to product mapping
                        Productmapping::insert(['tiendanube_id' => $this->shop->tiendanube_id, 'bbm_id_product' => $bbm_id_product, 'nuvem_id_product' => $response->body->id]);
                    }
                }
            }

            $lock = fopen(storage_path().'/logs/import.lock', 'a');
            ftruncate($lock, 0);
            fwrite($lock, json_encode(['status' => 'complete', 'current' => str_pad($count, 2, 0, STR_PAD_LEFT), 'total' => str_pad(count($productsAvailable), 2, 0, STR_PAD_LEFT)]));
            fclose($lock);

            return response()->json(['result' => 'Import successful']);
        } else {
            throw new Exception("There are no token. Please authenticate first!");
        }                   
    }

    public function token($id)
    {
        $this->shop = Nuvemshop::where('id', '=', $id)->first();
        $auth = new \TiendaNube\Auth($this->shop->client_id, $this->shop->client_secret);

        if($this->request->has('code')) {
            $store_info = $auth->request_access_token($this->request->input('code'));
            $this->shop->tiendanube_id = $store_info['store_id'];
            $this->shop->access_token = $store_info['access_token'];
            $this->shop->save();
            return redirect('/nuvemshop');
        } else {            
            // Keep the url according to the language you want
            $url = $auth->login_url_brazil();
            return redirect()->to($url);
        }
    }        
}