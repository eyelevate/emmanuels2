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
class InventoryItemsController extends Controller {
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
		$inventories = InventoryItem::prepareInventoryItems(InventoryItem::all());
		$companies = Company::find(1);

		//NEEDS TO BE CHANGE LATER
		$company_id = 1;
		$this->layout->content = View::make('inventory_items.index')
		->with('inventories',$inventories)
		->with('companies',$companies)
		->with('user_role',$user_role)
		->with('company_id',$company_id);
		
	}

	public function getAdd()
	{	
		
		$inventories = InventoryItem::prepareForSelect(Inventory::get());
		$this->layout->content = View::make('inventory_items.add')
		->with('inventories',$inventories);
	}
	public function postAdd()
	{
		$validator = Validator::make(Input::all(), InventoryItem::$rules_add);
		if ($validator->passes()) {
			$inventory_id = Input::get('inventory_id');
			$name = Input::get('name');
			$description = Input::get('description');
			$price = Input::get('price');

			$inventory_item = new InventoryItem;
			$inventory_item->name = $name;
			$inventory_item->description = $description;
			$inventory_item->price = $price;

			$inventory_item->inventory_id = $inventory_id;
			$inventory_item->owner_id =  Auth::user()->id;
			$inventory_item->company_id =  1;
			$inventory_item->status =  1;
			if($inventory_item->save()) { // Save
			 	return Redirect::action('InventoryItemsController@getIndex')
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
		$inventories = InventoryItem::prepareForSelect(Inventory::get());

		$inventory_items = InventoryItem::find($id);
		$this->layout->content = View::make('inventory_items.edit')
		->with('inventories',$inventories)
		->with('inventory_items',$inventory_items);
	}
	public function postEdit()
	{
		$validator = Validator::make(Input::all(), InventoryItem::$rules_add);
		if ($validator->passes()) {
			$id = Input::get('id');
			$inventory_id = Input::get('inventory_id');
			$name = Input::get('name');
			$description = Input::get('description');
			$price = Input::get('price');

			$inventory_item = InventoryItem::find($id);
			$inventory_item->name = $name;
			$inventory_item->description = $description;
			$inventory_item->price = $price;
			$inventory_item->inventory_id = $inventory_id;

			if($inventory_item->save()) { // Save
			 	return Redirect::action('InventoryItemsController@getIndex')
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
		$inventory = InventoryItem::find($inventory_id);
		if($inventory->delete()) {
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