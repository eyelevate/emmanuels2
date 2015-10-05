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
class ServicesController extends Controller {
	protected $layout = 'layouts.admin';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct() {
		// switch(Auth::user()->roles){
		// 	case 2:
		// 		$this->layout = "layouts.admin";
		// 	break;
		// 	case 3:
		// 		$this->layout = "layouts.admin_owners";
		// 	break;
		// 	case 4:
		// 		$this->layout = "layouts.admin_employees";
		// 	break;
		// 	case 5:
		// 		$this->layout = "layouts.admin_members";
		// 	break;
		// 	case 6:
		// 		$this->layout = "layouts.admin";
		// 	break;
		// }
		$this->beforeFilter('csrf', array('on'=>'post'));


	}
	public function getIndex()
	{

		$services = Service::prepareServices(Service::all());

		$this->layout->content = View::make('services.index')
		->with('services',$services);
		
	}

	public function getAdd()
	{	
		$types = Service::prepareTypes();
		$this->layout->content = View::make('services.add')
		->with('types',$types);

	}
	public function postAdd()
	{
		$validator = Validator::make(Input::all(), Service::$rules_add);
		if ($validator->passes()) {
			$name = Input::get('name');
			$description = Input::get('description');
			$rate = Input::get('rate');
			$type = Input::get('type');

			$service = new Service;
			$service->name = $name;
			$service->description = $description;
			$service->rate = $rate;
			$service->type = $type;
			$service->company_id =  1;
			$service->status =  1;


			 if($service->save()) { // Save
			 	return Redirect::action('ServicesController@getIndex')
			 	->with('message', 'Successfully added a menu item')
			 	->with('alert_type','alert-success');
			 } else {
			 	return Redirect::back()
			 	->with('message', 'Oops, somthing went wrong. Please try again.')
			 	->with('alert_type','alert-danger');	
			 }

			} 	else {
	        	// validation has failed, display error messages    
				return Redirect::back()
				->with('message', 'The following errors occurred')
				->with('alert_type','alert-danger')
				->withErrors($validator)
				->withInput();	    	
			}
		}

		public function getEdit($id = null)
		{	
			$types = Service::prepareTypes();
			$services = Service::find($id);
			$this->layout->content = View::make('services.edit')
			->with('services',$services)
			->with('types',$types);
		}
		public function postEdit()
		{
			$validator = Validator::make(Input::all(), Service::$rules_add);
			if ($validator->passes()) {
				$id = Input::get('id');
				$name = Input::get('name');
				$description = Input::get('description');
				$rate = Input::get('rate');
				$type = Input::get('type');
				$service = Service::find($id);
				$service->name = $name;
				$service->description = $description;
				$service->rate = $rate;
				$service->type = $type;

			 if($service->save()) { 
			 	// Save
			 	return Redirect::action('ServicesController@getIndex')
			 	->with('message', 'Successfully added a menu item')
			 	->with('alert_type','alert-success');
			 } else {
			 	return Redirect::back()
			 	->with('message', 'Oops, somthing went wrong. Please try again.')
			 	->with('alert_type','alert-danger');	
			 }

			} 	else {
	        	// validation has failed, display error messages    
				return Redirect::back()
				->with('message', 'The following errors occurred')
				->with('alert_type','alert-danger')
				->withErrors($validator)
				->withInput();	    	
			}
		}

		public function postDelete()
		{
			$service_id = Input::get('service_id');
			$service = Service::find($service_id);
			if($service->delete()) {
				return Redirect::back()
				->with('message', 'Successfully Deleted!')
				->with('alert_type','alert-success');

			} else {
				return Redirect::back()
				->with('message', 'Oops, somthing went wrong. Please try again.')
				->with('alert_type','alert-danger');	
			}
		}

	}