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
use App\MenuItem;

class ResourcesController extends Controller {
	//set layout
	protected $layout = "layouts.admin";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct() {

		// Check if user is authorized to view the page
		$routes = explode("@", Route::currentRouteAction(), 2);     
        $this->controller = strtolower(str_replace('Controller', '', $routes[0]));
        $this->method = $routes[1];
        $this->parameters = Route::current()->parameters();
        $this->company_id = 1;
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

     
     	// Page content setup
        $role_id = (isset($member_id)) ? Auth::user()->roles : null;
        $role_name = Admin::getRoleName($role_id);
	
        View::share('role',$role_name);
       	View::share('controller',$this->controller);
		View::share('action',$this->method);

	}

public function getIndex() {

		$path = 'assets/img';
		$resources = array();
		$folders = scandir($path);


		
		if(count($folders)>0) {
			foreach ($folders as $key => $value) {

				if($value > 0) {
					$resources[$key]['company'] = Company::find($key);
					$resources[$key]['images'] = glob($path.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.'*.*');
				}
			}
		}

		return view('resources.index')

			->with('layout',$this->layout)
			->with('resources',$resources);


		// return Datatables::of($companies)->make();
	}
	public function getAdd() {

		$time = Company::getDayHours();
		$country = Company::country_code();

		//var_dump($cities);
		 return view('resources.add')
		 ->with('layout',$this->layout)
			->with('time',$time)
			->with('country_code',$country);
	}

	/*
	* Processes the company form and redirect with a flash if successful else go back with errors
	*
	*/

	public function postAdd(){

		$validator = Validator::make(Input::all(), Company::$rules);
	 
	    if ($validator->passes()) {
			$store_hours = Company::prepareStoreHours(Input::get('hours'));

			$owner_id = (isset(Auth::user()->parent_id)) ? Auth::user()->parent_id : Auth::user()->id;	    	
	        // validation has passed, save user in DB
			$company = new Company;
			$company->name = Input::get('name');
			$company->nick_name = Input::get('nick_name');
			$company->phone = Input::get('phone');
			$company->email = Input::get('email');
			$company->street = Input::get('street');
			$company->zipcode = Input::get('zipcode');
			$company->city = Input::get('city');
			$company->state = Input::get('state');
			$company->region = Input::get('region');
			$company->country = Input::get('country');
			$company->store_hours = $store_hours;
			$company->url = Input::get('url');
			$company->payment_period = Input::get('payment_period');
			$company->status = 1;
			$company->save();

		    return Redirect::to('/companies')
		    	->with('message', 'Successfully Registered Company!')
		    	->with('alert_type','alert-success');

	    } else {
	        // validation has failed, display error messages    
	        return Redirect::to('/companies/add')
	        	->with('message', 'The following errors occurred')
	        	->with('alert_type','alert-danger')
	        	->withErrors($validator)
	        	->withInput();
	    }
	}
	public function getEdit() {

		$companies = Company::find($this->company_id);
		$path = 'assets/img'.DIRECTORY_SEPARATOR.$this->company_id;
		$resources = glob($path.DIRECTORY_SEPARATOR.'*.*');
		// $this->layout = View::make('layouts.admin_company'); // Override controller layout
		 return view('resources.edit')
		 ->with('layout',$this->layout)
			->with('resources',$resources)
			->with('companies',$companies);		
	}

	public function postEdit(){

		$store_hours = Company::prepareStoreHours(Input::get('hours'));

		$owner_id = (isset(Auth::user()->parent_id)) ? Auth::user()->parent_id : Auth::user()->id;	    	
        // validation has passed, save user in DB
		$id = $this->company_id;
		$company = Company::find($id);
		$company->name = Input::get('name');
		$company->nick_name = Input::get('nick_name');
		$company->phone = Input::get('phone');
		$company->email = Input::get('email');
		$company->street = Input::get('street');
		$company->zipcode = Input::get('zipcode');
		$company->city = Input::get('city');
		$company->state = Input::get('state');
		$company->region = Input::get('region');
		$company->country = Input::get('country');
		$company->store_hours = $store_hours;
		$company->url = Input::get('url');
		$company->payment_period = Input::get('payment_period');
		$company->status = 1;
		$company->save();

		return Redirect::action('CompaniesController@getIndex',Input::get('id'))
	    	->with('message', 'Successfully updated company!')
	    	->with('alert_type','alert-success');

	}

	public function postFileupload() {

		error_reporting(E_ALL | E_STRICT);
		$upload_handler = new UploadHandler();
		$this->layout = '';
		$company_id = $this->company_id;
		$path = 'tmp/img';
		// Loop through the tmp/img folder and move all uploaded images to their respective folders
		foreach (glob($path.DIRECTORY_SEPARATOR.'*.*') as $file) {
			$new_dest = 'img/'.$company_id.'/'.strtotime(date('Y-m-d H:i:s')).'-';
			$new_file_name = str_replace('tmp/img/', $new_dest, $file);
			if(rename($file, $new_file_name)) {
				// Specify the target directory and add forward slash
				$thumbs = "tmp/img/thumbnail";
				// Loop over all of the files in the folder
				foreach(glob($thumbs.DIRECTORY_SEPARATOR."*.*") as $thumb) {
				    unlink($thumb); // Delete each file through the loop
				}					
			}
		}

	}
	public function postDelete() {

		$this->layout = '';
		$src = Input::get('src');
		$response = array('status'=>false);
		if(!empty($src)) {
			if(unlink($src)) {
				$response['status'] = true;
			}
		}

		return json_encode($response);
	}


}