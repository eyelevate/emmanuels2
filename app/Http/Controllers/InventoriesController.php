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
class InventoriesController extends Controller {
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
		$user_role = Auth::user()->roles;
		$inventories = (isset($id)) ? Inventory::prepareInventory(Inventory::where('company_id',$id)->get()) : Inventory::prepareInventory(Inventory::all());
		$companies = Company::find(1);

		//NEEDS TO BE CHANGE LATER
		$company_id = 1;
		$this->layout->content = View::make('inventories.index')
		->with('inventories',$inventories)
		->with('companies',$companies)
		->with('user_role',$user_role)
		->with('company_id',$company_id);
	}

	public function getAdd()
	{
		$this->layout->content = View::make('inventories.add');
	}
	public function postAdd()
	{
		$validator = Validator::make(Input::all(), Inventory::$rules_add);
		if ($validator->passes()) {
			$name = Input::get('name');
			$description = Input::get('description');

			$inventory = new Inventory;
			$inventory->name = $name;
			$inventory->description = $description;
			$inventory->owner_id =  Auth::user()->id;
			$inventory->company_id =  1;
			$inventory->status =  1;


			 if($inventory->save()) { // Save
			 	return Redirect::action('InventoriesController@getIndex')
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
			$inventories = Inventory::find($id);
			$this->layout->content = View::make('inventories.edit')
			->with('inventory',$inventories);
		}
		public function postEdit()
		{

			$validator = Validator::make(Input::all(), Inventory::$rules_add);
			if ($validator->passes()) {
				$inventory_id = Input::get('id');
				$name = Input::get('name');
				$description = Input::get('description');

				$inventory = Inventory::find($inventory_id);
				$inventory->name = $name;
				$inventory->description = $description;
				
			 if($inventory->save()) { // Save
			 	return Redirect::action('InventoriesController@getIndex')
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
			$inventory_id = Input::get('inventory_id');
			$inventory = Inventory::find($inventory_id);
			$count = count(InventoryItem::where('inventory_id',$inventory_id)->where('company_id',$inventory->company_id)->get());
			$inventory_items = InventoryItem::where('inventory_id',$inventory_id)->where('company_id',$inventory->company_id)->get();
			if($count>0){
				if($inventory->delete() && $inventory_items->delete()) {
					return Redirect::back()
					->with('message', 'Successfully Deleted!')
					->with('alert_type','alert-success');

				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again. items and inventories')
					->with('alert_type','alert-danger');	
				}

			} elseif($inventory->delete()) {

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