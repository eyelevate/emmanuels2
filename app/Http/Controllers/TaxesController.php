<?php
namespace App\Http\Controllers;

use Input;
use Validator;
use Redirect;
use Hash;
use Request;
use Route;
use Response;
use Auth;
use URL;
use Session;
use Laracasts\Flash\Flash;
use View;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Admin;
use App\Role;
use App\Permission;
use App\PermissionRole;
use App\Website;
use App\Company;
use App\Menu;
use App\Page;
use App\Tax;

class TaxesController extends Controller {
protected $layout = 'layouts.admin';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct() {

        // // Define layout
        $this->layout = 'layouts.admins';
        $this_username = null;
        //PROFILE IMAGE
        $this_user_profile_image = null;
        if (Auth::check()) {
        $this_user = User::find(Auth::user()->id);
        $this_username = $this_user->username;

        //PROFILE IMAGE
        $this_user_profile_image = Job::imageValidator($this_user->profile_image);
        }

        View::share('this_username',$this_username);
        View::share('this_user_profile_image',$this_user_profile_image);
        $notif = Job::prepareNotifications();
        View::share('notif',$notif);

	    
	}

	public function getIndex()
	{
		$taxes = Tax::prepareForView(Tax::orderBy('zipcode')->get());
		return view('taxes.index')
			->with('layout',$this->layout)
			->with('taxes',$taxes);
	}

	public function getAdd()
	{
		$tax_status = Tax::taxStatus();
		return view('taxes.add')
			->with('layout',$this->layout)
			->with('tax_status',$tax_status);
	}
	public function postAdd()
	{
		
	}

	public function getEdit($id = null)
	{
		return view('taxes.edit')
			->with('layout',$this->layout);
	}
	public function postEdit()
	{
		
	}

	public function postDelete()
	{
		$tax_id = Input::get('tax_id');
		$tax = Tax::find($tax_id);
		if($tax->delete()) {
			return Redirect::action('TaxesController@getIndex')
			->with('message', 'Successfully deleted!')
			->with('alert_type','alert-success');
		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}
}