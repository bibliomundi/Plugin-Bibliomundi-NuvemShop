<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\User;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class UserController extends Controller
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
        $users = User::paginate(10);
        return view('admin.user.index', ['users' => $users]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if($user->delete()) {
            Session::flash('alert','Delete successfully.');
            Session::flash('alert_class','alert-info');
            return redirect('user/');
        }
    }
}