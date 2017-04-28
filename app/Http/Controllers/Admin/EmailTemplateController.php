<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Nuvemshop;
use App\EmailTemplate;

class EmailTemplateController extends Controller
{
    public $request;

    public $nuvemShop;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // Get the current request object
        $this->request = $request;

        // Get the nuvemshop object
        $nuvemshop_id = Route::current()->parameter('nuvemShopId');

        $this->nuvemShop = Nuvemshop::findOrFail($nuvemshop_id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->nuvemShop->emailTemplate) {
            return $this->show($this->nuvemShop->id, $this->nuvemShop->emailTemplate->id);
        }
        else {
             return $this->create();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.emailtemplate.form', array('nuvemShop' => $this->nuvemShop));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // Get params
        $params = $this->request->only('from_name', 'from_address', 'subject', 'header', 'footer', 'content');

        // Add  other needed params
        $params['nuvemshop_id'] = $this->nuvemShop->id;

        // Create new model and save to DB
        $template = EmailTemplate::create($params);

        // Set notice
        Session::flash('alert', __('emailtemplate.create_success'));
        Session::flash('alert_class','alert-info');

        return $this->show($this->nuvemShop->id, $template->id);
    }

    /**
     * Display the specified resource.
     * @param  [type] $nuvemshopId      [description]
     * @param  [type] $emailTemplateId  [description]
     * @return [type]                   [description]
     */
    public function show($nuvemShopId, $emailTemplateId)
    {
        // Get the template
        $template = EmailTemplate::findOrFail($emailTemplateId);

        // Return to edit view
        return view('admin.emailtemplate.form', array('nuvemShop' => $this->nuvemShop,
                                                    'template' => $template));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  [type] $nuvemshopId      [description]
     * @param  [type] $emailTemplateId  [description]
     * @return [type]                   [description]
     */
    public function edit($nuvemShopId, $emailTemplateId)
    {   
        return $this->show($this->nuvemShop->id, $emailTemplateId);
    }

    /**
     * Update the specified resource in storage.
     * @param  [type] $nuvemshopId      [description]
     * @param  [type] $emailTemplateId  [description]
     * @return [type]                   [description]
     */
    public function update($nuvemShopId, $emailTemplateId)
    {
        // Get the template
        $template = EmailTemplate::findOrFail($emailTemplateId);

        // Get params
        $params = $this->request->only('from_name', 'from_address', 'subject', 'header', 'footer', 'content');

        $params['nuvemshop_id'] = $this->nuvemShop->id;

        // Update to DB
        $template->update($params);

        // Set notice
        Session::flash('alert', __('emailtemplate.update_success'));
        Session::flash('alert_class','alert-info');

        return $this->show($this->nuvemShop->id, $template->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  [type] $nuvemshopId      [description]
     * @param  [type] $emailTemplateId  [description]
     * @return [type]                   [description]
     */
    public function destroy($nuvemShopId, $emailTemplateId)
    {
        // Get the template
        $template = EmailTemplate::findOrFail($emailTemplateId);

        $template->delete();

        // Set notice
        Session::flash('alert', __('emailtemplate.delete_success'));
        Session::flash('alert_class','alert-info');

        return redirect()->route('nuvemshops.edit', array('id' => $this->nuvemShop->id));
    }
}
