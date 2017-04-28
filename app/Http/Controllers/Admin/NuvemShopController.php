<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Nuvemshop;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class NuvemshopController extends Controller
{
	public $request;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		$this->middleware('auth');
		$this->request = $request;
	}

	/**
	 * Show the application dashboard.
	 * @return list
	 */
	public function index()
    {        
        // DB::enableQueryLog();
        $shops = Nuvemshop::paginate(10);
        return view('admin.nuvemshop.index', ['shops' => $shops]);
    }

	public function form($id = null)
    {
        if ($this->request->method() == 'POST') {
            if ($id) {
                $nuvemshop = Nuvemshop::find($id);
            } else {
                $nuvemshop = new Nuvemshop();
            }
            $nuvemshop->client_id = $this->request->input('client_id');
            $nuvemshop->client_secret = $this->request->input('client_secret');

            if ($nuvemshop->save()) {
                Session::flash('alert','Save successfully.');
                Session::flash('alert_class','alert-info');
                return redirect('/nuvemshop');
            }
        }
        $nuvemshop = Nuvemshop::find($id);
        return view('admin.nuvemshop.form', [
            'nuvemshop' => $nuvemshop
        ]);
    }

    public function delete($id)
    {
        $nuvemshop = Nuvemshop::find($id);
        if($nuvemshop->delete()) {
            Session::flash('alert','Delete successfully.');
            Session::flash('alert_class','alert-info');
            return redirect('nuvemshop/');
        }
    }
}