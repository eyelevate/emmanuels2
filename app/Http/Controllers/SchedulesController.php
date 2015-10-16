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
use App\Schedule;
use App\Page;
use App\Delivery;

class SchedulesController extends Controller{
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


        //
        $this->role_id = (isset(Auth::user()->roles)) ? Auth::user()->roles : null;
		$init_message = Website::WebInit();
	}

	public function getIndex()
	{

		$schedules = Schedule::prepareSchedules(Schedule::get());
		return view('schedules.index')
		->with('layout',$this->layout)
		->with('schedules',$schedules);
	}

	public function getAdd()
	{
			return view('schedules.add')
			->with('layout',$this->layout);
	}
	// public function getAdd()
	// {
	// 	//CHECK IF PREVIEW SESSION EXISTS, IF SO THE USER IS COMING BACK FROM PREVIEW PAGE
	// 	if (Session::get('preview_data')){
	// 		$searchBy = Delivery::search_by();
	// 		//PREPARE HTML ORDERS FOR VIEW
	// 		$preview_session = Session::get('preview_data');
	// 		$orders_html   = Schedule::prepareOrderFromSession($preview_session);
	// 		return view('schedules.add')
	// 		->with('search_by',$searchBy)
	// 		->with('preview_data',Session::get('preview_data'))
	// 		->with('layout',$this->layout)
	// 		->with('orders_html',$orders_html);
	// 	} else {
	// 		$searchBy = Delivery::search_by();
	// 		return view('schedules.add')
	// 		->with('layout',$this->layout)
	// 		->with('search_by',$searchBy);
	// 	}
	// }

	public function postPreview()
	{

		$validator = Validator::make(Input::all(), Schedule::$rules_add);
		if ($validator->passes()) { //VALIDATION PASSED
			if (Session::get('preview_data'))
				Session::forget('preview_data');
			$prepared_data = Schedule::prepareAllForPreview(Input::all());
			//SAVE ALL THE DATA IN SESSION FOR EDITING PURPOSES
			Session::put('preview_data', $prepared_data);
			//EVERYTHING LOOKS GOOD FORWARD TO PREVIEW PAGE FOR APPROVAL
			return view('schedules.preview')
				->with('layout',$this->layout)
				->with('input_all',$prepared_data);
		} 	else {
		// validation has failed, display error messages    
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	
		}	
	}
		public function postAdd()
	{
		$validator = Validator::make(Input::all(), Schedule::$rules_add);
		if ($validator->passes()) { //VALIDATION PASSED
			$schedules = new Schedule;
			$schedules->title = Input::get('title');
			$schedules->description = Input::get('description');
			$schedules->status = 1;
			if ($schedules->save()) {
				return Redirect::route('rules_add',$schedules->id);
			}
		} 	else {
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	
		}

	}

	// 	public function postAdd()
	// {

	// 	if (Session::get('preview_data')) {
	// 		//GET ALL DATA
	// 		$all_inputs = Session::get('preview_data');
	// 		// CHECK IF THE ADDRESS WAS NEW
	// 		if ($all_inputs['new_street'] &&
	// 			$all_inputs['new_unit'] &&
	// 			$all_inputs['new_city'] &&
	// 			$all_inputs['new_state'] &&
	// 			$all_inputs['new_zipcode']) { 
	// 			//NEW ADDRESS WAS SET
	// 			$street = $all_inputs['new_street'];
	// 			$unit = $all_inputs['new_unit'];
	// 			$city = $all_inputs['new_city'];
	// 			$state = $all_inputs['new_state'];
	// 			$zipcode = $all_inputs['new_zipcode'];
	// 		} else {
	// 			$street = $all_inputs['street'];
	// 			$unit = $all_inputs['unit'];
	// 			$city = $all_inputs['city'];
	// 			$state = $all_inputs['state'];
	// 			$zipcode = $all_inputs['zipcode'];
	// 		}

	// 		//SET IN-STORE IN-HOUSE
	// 		if (isset($all_inputs['store_or_house'])) {
	// 			//1 IN-STORE, 2 IN-HOUSE
	// 			$store_or_house = $all_inputs['store_or_house'];
	// 		}

	// 		//GET USER INFO
	// 		if (isset($all_inputs['user_id'])) {
	// 			$user_id = $all_inputs['user_id'];
	// 		} else {
	// 			$user_id = null;
	// 		}


	// 		$first_name = $all_inputs['first_name'];
	// 		$last_name = $all_inputs['last_name'];

	// 		$email = $all_inputs['email'];
	// 		$phone = $all_inputs['phone'];
	// 		//GET OTHER INFORMATION
	// 		$will_phone = ($all_inputs['will_phone'] == "checked")?true:false;
	// 		//WILL BE SAVE AS TYPE
	// 		$estimate_or_order = $all_inputs['estimate_or_order'];

	// 		//COUNT THE TOTAL NUMBER OF ORDERS, INCLUDING BOTH SERVICES AND ITEMS
	// 		$orders_count = 0;
	// 		if (isset($all_inputs['service_order'])) {//SERVICES
	// 			$services_count = count($all_inputs['service_order']);
	// 			$orders_count = $orders_count + $services_count;
	// 		}
	// 		if (isset($all_inputs['item_order'])) {//ITEM
	// 			$items_count = count($all_inputs['item_order']);
	// 			$orders_count = $orders_count + $items_count;
	// 		}

	// 		//SET PRICES
	// 		$total_before_tax = $all_inputs['total_befor_tax'];
	// 		$total_after_tax = $all_inputs['total_after_tax'];
	// 		$tax = $all_inputs['tax'];

	// 		//PROCESSING THE INVOICE AND INVOICE ITEMS
	// 		if (isset($all_inputs['service_order']) || isset($all_inputs['item_order'])) {
	// 			$invoice = new Invoice;
	// 			//WORK ORDER OR ESTIMATE
	// 			$invoice->type = $estimate_or_order;
	// 			//EMPTY FOR NOW
	// 			$invoice->description = null;
	// 			//TOTAL ORDERS
	// 			$invoice->quantity = $orders_count;
	// 			$invoice->pretax = $total_before_tax;
	// 			$invoice->tax = $tax;
	// 			//TOTAL AFTER TAX
	// 			$invoice->total = $total_after_tax;
	// 			$invoice->status = 1;
	// 			if($invoice->save()) { //IF SUCCESS, SAVE EACH ORDERS SEPARATELY
	// 				if (isset($all_inputs['service_order'])) {//SERVICES

	// 					foreach ($all_inputs['service_order'] as $so_key => $so_value) {
	// 						$invoice_item = new InvoiceItem();
	// 						$invoice_item->invoice_id = $invoice->id;
	// 						//TYPE 1 IS SERVICE
	// 						$invoice_item->type = 1;
	// 						$invoice_item->inventory_item_id = $so_value['id'];
	// 						$invoice_item->total = $so_value['total'];
	// 						$invoice_item->height = $so_value['height'];
	// 						$invoice_item->length = $so_value['length'];
	// 						//THIS IS NOT THE SERVICE ID(NOT MAKE), ITS THE ITEM BELLOW MAKE IN THE FORM
	// 						$invoice_item->item_id = $so_value['item_id'];
	// 						$invoice_item->status = 1;
	// 						$invoice_item->save();
	// 					}

	// 				}
	// 				if (isset($all_inputs['item_order'])) {//ITEM
	// 					foreach ($all_inputs['item_order'] as $io_key => $io_value) {
	// 						$invoice_item = new InvoiceItem();
	// 						$invoice_item->invoice_id = $invoice->id;
	// 						//TYPE 2 IS ITEM
	// 						$invoice_item->type = 2;
	// 						$invoice_item->inventory_item_id = $io_value['id'];
	// 						$invoice_item->total = $io_value['total'];
	// 						$invoice_item->quantity = $io_value['qty'];
	// 						$invoice_item->status = 1;
	// 						$invoice_item->save();
	// 					}
	// 				}
	// 				//SAVE THE SCHEDULE
	// 				$schedules = new Schedule();
	// 				//INVOICE ID
	// 				$schedules->invoice_id = $invoice->id;
	// 				//FOR NOW FIRSTNAME HOLDS BOTH FIRST NAME AND LAST NAME
	// 				//INFO
	// 				$schedules->user_id = $user_id;
	// 				$schedules->firstname = $first_name;
	// 				$schedules->lastname = $last_name;
	// 				$schedules->email = $email;
	// 				$schedules->phone = $phone;
	// 				//ADDRESS
	// 				$schedules->street = $street;
	// 				$schedules->unit = $unit;
	// 				$schedules->city = $city;
	// 				$schedules->state = $state;
	// 				$schedules->zipcode = $zipcode;
	// 				//OTHER INFO
	// 				//TYPE 1 = SERVICE, 2 = ITEM
	// 				$schedules->type = $estimate_or_order;
	// 				$schedules->will_phone = $will_phone;

	// 				//IN-STORE, IN-HOUSE
	// 				$schedules->place = $store_or_house;

	// 				//PICKUP, DELIVERY DATE
	// 				$pickup_date = $all_inputs['pickup_date'];
	// 				$delivery_date = $all_inputs['delivery_date'];
	// 				$schedules->pickup_date = date("Y-m-d H:i:s",strtotime($pickup_date));
	// 				$schedules->delivery_date = date("Y-m-d H:i:s",strtotime($delivery_date));

	// 				$schedules->status = 1;

	// 				if ($schedules->save()) { // Save
	// 					//FORGET THE SESSION
	// 	            	if (Session::get('preview_data'))
	// 	            		Session::forget('preview_data');
	// 	            	return Redirect::action('SchedulesController@getIndex')
	// 	            	->with('message', 'Successfully added a Schedule')
	// 	            	->with('alert_type', 'alert-success');
	// 	            } else {
	// 	            	return Redirect::back()
	// 	            	->with('message', 'Oops, somthing went wrong. Please try again.')
	// 	            	->with('alert_type', 'alert-danger');
	// 	            }
	// 			}
	// 		}
	// 	} else {
	// 		//SOMTHING WENT WRONG SESSION NOT SUPPOSED TO BE EMPTY
	// 	}
	// }

	public function getEdit($id = null)
	{
		if (isset($id)) {
			$schedules = Schedule::find($id);
			$prepare_select = Schedule::prepareSelect();
			return view('schedules.edit')
				->with('layout',$this->layout)
				->with('prepare_select',$prepare_select)
				->with('schedules',$schedules);
		}
		
	}
	public function postEdit()
	{
		$validator = Validator::make(Input::all(), Schedule::$rules_add);
		if ($validator->passes()) { //VALIDATION PASSED
			$schedules = Schedule::find(Input::get('id'));
			$schedules->title = Input::get('title');
			$schedules->description = Input::get('description');
			$schedules->status = Input::get('status');
			if ($schedules->save()) {
				return Redirect::route('schedules_index');
			}
		} 	else {
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	
		}

	}
	// public function postEdit()
	// {
	// 	if (Session::get('preview_data')) {
	// 		//GET ALL DATA
	// 		$all_inputs = Session::get('preview_data');
	// 		// CHECK IF THE ADDRESS WAS NEW
	// 		if ($all_inputs['new_street'] &&
	// 			$all_inputs['new_unit'] &&
	// 			$all_inputs['new_city'] &&
	// 			$all_inputs['new_state'] &&
	// 			$all_inputs['new_zipcode']) { 
	// 			//NEW ADDRESS WAS SET
	// 			$street = $all_inputs['new_street'];
	// 			$unit = $all_inputs['new_unit'];
	// 			$city = $all_inputs['new_city'];
	// 			$state = $all_inputs['new_state'];
	// 			$zipcode = $all_inputs['new_zipcode'];
	// 		} else {
	// 			$street = $all_inputs['street'];
	// 			$unit = $all_inputs['unit'];
	// 			$city = $all_inputs['city'];
	// 			$state = $all_inputs['state'];
	// 			$zipcode = $all_inputs['zipcode'];
	// 		}

	// 		//GET USER INFO
	// 		if (isset($all_inputs['user_id'])) {
	// 			$user_id = $all_inputs['user_id'];
	// 		} else {
	// 			$user_id = null;
	// 		}

	// 		//SET IN-STORE IN-HOUSE
	// 		if (isset($all_inputs['store_or_house'])) {
	// 			//1 IN-STORE, 2 IN-HOUSE
	// 			$store_or_house = $all_inputs['store_or_house'];
	// 		}

	// 		$first_name = $all_inputs['first_name'];
	// 		$last_name = $all_inputs['last_name'];
	// 		$email = $all_inputs['email'];
	// 		$phone = $all_inputs['phone'];
	// 		//GET OTHER INFORMATION
	// 		$will_phone = ($all_inputs['will_phone'] == "checked")?true:false;
	// 		//WILL BE SAVE AS TYPE
	// 		$estimate_or_order = $all_inputs['estimate_or_order'];

	// 		//COUNT THE TOTAL NUMBER OF ORDERS, INCLUDING BOTH SERVICES AND ITEMS
	// 		$orders_count = 0;
	// 		if (isset($all_inputs['service_order'])) {//SERVICES
	// 			$services_count = count($all_inputs['service_order']);
	// 			$orders_count = $orders_count + $services_count;
	// 		}
	// 		if (isset($all_inputs['item_order'])) {//ITEM
	// 			$items_count = count($all_inputs['item_order']);
	// 			$orders_count = $orders_count + $items_count;
	// 		}

	// 		//SET PRICES
	// 		$total_before_tax = $all_inputs['total_befor_tax'];
	// 		$total_after_tax = $all_inputs['total_after_tax'];
	// 		$tax = $all_inputs['tax'];


	// 		//PROCESSING THE INVOICE AND INVOICE ITEMS
	// 		if (isset($all_inputs['service_order']) || isset($all_inputs['item_order'])) {
	// 			$invoice_id = $all_inputs['invoice_id'];
	// 			$invoice = Invoice::find($invoice_id);
	// 			//WORK ORDER OR ESTIMATE
	// 			$invoice->type = $estimate_or_order;
	// 			//EMPTY FOR NOW
	// 			$invoice->description = null;
	// 			//TOTAL ORDERS
	// 			$invoice->quantity = $orders_count;
	// 			$invoice->pretax = $total_before_tax;
	// 			$invoice->tax = $tax;
	// 			//TOTAL AFTER TAX
	// 			$invoice->total = $total_after_tax;
	// 			$invoice->status = 1;

	// 			//DELETE ALL ITEMS(ORDERS, INVOICE_ITEMS) THAT BELLONG TO THIS INVOICE
	// 			$old_invoice_items = InvoiceItem::where('invoice_id', $invoice_id)->get();
	// 			foreach ($old_invoice_items as $oii_key => $oii_value) {
	// 				$oii_value->delete();
	// 			}


	// 			if($invoice->save()) { //IF SUCCESS, SAVE EACH ORDERS SEPARATELY
	// 				if (isset($all_inputs['service_order'])) {//SERVICES

	// 					foreach ($all_inputs['service_order'] as $so_key => $so_value) {
	// 						$invoice_item = new InvoiceItem();
	// 						$invoice_item->invoice_id = $invoice->id;
	// 						//TYPE 1 IS SERVICE
	// 						$invoice_item->type = 1;
	// 						$invoice_item->inventory_item_id = $so_value['id'];
	// 						$invoice_item->total = $so_value['total'];
	// 						$invoice_item->height = $so_value['height'];
	// 						$invoice_item->length = $so_value['length'];
	// 						//THIS IS NOT THE SERVICE ID(NOT MAKE), ITS THE ITEM BELLOW MAKE IN THE FORM
	// 						$invoice_item->item_id = $so_value['item_id'];
	// 						$invoice_item->status = 1;
	// 						$invoice_item->save();
	// 					}

	// 				}
	// 				if (isset($all_inputs['item_order'])) {//ITEM
	// 					foreach ($all_inputs['item_order'] as $io_key => $io_value) {
	// 						$invoice_item = new InvoiceItem();
	// 						$invoice_item->invoice_id = $invoice->id;
	// 						//TYPE 2 IS ITEM
	// 						$invoice_item->type = 2;
	// 						$invoice_item->inventory_item_id = $io_value['id'];
	// 						$invoice_item->total = $io_value['total'];
	// 						$invoice_item->quantity = $io_value['qty'];
	// 						$invoice_item->status = 1;
	// 						$invoice_item->save();
	// 					}
	// 				}
	// 				$schedule_id = $all_inputs['schedule_id'];
	// 				//SAVE THE SCHEDULE
	// 				$schedules = Schedule::find($schedule_id);
	// 				//INVOICE ID
	// 				$schedules->invoice_id = $invoice->id;
	// 				//FOR NOW FIRSTNAME HOLDS BOTH FIRST NAME AND LAST NAME
	// 				//INFO
	// 				$schedules->user_id = $user_id;


	// 				$schedules->firstname = $first_name;
	// 				$schedules->lastname = $last_name;

	// 				$schedules->email = $email;
	// 				$schedules->phone = $phone;
	// 				//ADDRESS
	// 				$schedules->street = $street;
	// 				$schedules->unit = $unit;
	// 				$schedules->city = $city;
	// 				$schedules->state = $state;
	// 				$schedules->zipcode = $zipcode;
	// 				//OTHER INFO
	// 				//TYPE 1 = SERVICE, 2 = ITEM
	// 				$schedules->type = $estimate_or_order;
	// 				$schedules->will_phone = $will_phone;

	// 				//IN-STORE, IN-HOUSE
	// 				$schedules->place = $store_or_house;

	// 				//PICKUP, DELIVERY DATE
	// 				$pickup_date = $all_inputs['pickup_date'];
	// 				$delivery_date = $all_inputs['delivery_date'];
	// 				$schedules->pickup_date = date("Y-m-d H:i:s",strtotime($pickup_date));
	// 				$schedules->delivery_date = date("Y-m-d H:i:s",strtotime($delivery_date));

	// 				$schedules->status = 1;

	// 				if ($schedules->save()) { // Save
	// 					//FORGET THE SESSION
	// 	            	if (Session::get('preview_data'))
	// 	            		Session::forget('preview_data');
	// 	            	return Redirect::action('SchedulesController@getIndex')
	// 	            	->with('message', 'Successfully added a Schedule')
	// 	            	->with('alert_type', 'alert-success');
	// 	            } else {
	// 	            	return Redirect::back()
	// 	            	->with('message', 'Oops, somthing went wrong. Please try again.')
	// 	            	->with('alert_type', 'alert-danger');
	// 	            }
	// 			}
	// 		}
	// 	} else {
	// 		//SOMTHING WENT WRONG SESSION NOT SUPPOSED TO BE EMPTY
	// 	}
	// }

	//FRONTEND PORTION
	//**
	//**
		public function getNew()
	{
		//FORGET ALL SESSIONS
    	if (Session::get('guest_info'))
			Session::forget('guest_info');

		return view('layouts.frontend');
		if (Auth::check()) {//THE USER IS LOGGED IN PROCEED TO DETAILS
			return Redirect::to('/schedule/details');
		} else {
			return view('schedules.new');
		}
	}
	public function postNew()
	{
		return view('layouts.frontend');

		$member = Input::get('member');//IF TRUE, MEMBER FORM WERE SUBMITED
		$guest = Input::get('guest');//IF TRUE, GUEST FORM WERE SUBMITED

		if ($member == true) {
			if (Auth::attempt(array('username'=>Input::get('username'), 'password'=>Input::get('password')))) {
				return Redirect::to('/schedule/details')
					->with('message', 'You are now logged in!')
					->with('alert_type', 'alert-success');
			} else {
				return Redirect::back()
				->with('message', 'Your username/password combination was incorrect')
				->with('alert_type','alert-danger')
				->withInput();
			}
		}

		if ($guest == true) {
			$validator = Validator::make(Input::all(), Schedule::$schedules_add_frontend);
			if ($validator->passes()) {

				$user_info = [
				"first_name" => Input::get('first_name'),
				"last_name" => Input::get('last_name'),
				"phone" => Input::get('phone'),
				"email" => Input::get('email'),
				"street" => Input::get('street'),
				"unit" => Input::get('unit'),
				"city" => Input::get('city'),
				"state" => Input::get('state'),
				"zipcode" => Input::get('zipcode')
				];

				//GUEST INFORMATION IS SAVED, PROCEED TO NEXT PAGE
				Session::put('guest_info', $user_info);

				if (Session::get('guest_info')) {
					return Redirect::to('/schedule/details');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again. items and inventories')
					->with('alert_type','alert-danger');	
				}
				
			} else {
	        // validation has failed, display error messages    
				return Redirect::back()
				->with('alert_type','alert-danger')
				->withErrors($validator)
				->withInput();	
			}
		}
	
	}

	public function getDetails()
	{
		return view('layouts.frontend');
		//SESSION WAS SET CONTINUE TO DETAILES PAGE
		if (Session::get('guest_info') || Auth::check()) {
			// $this->layout = View::make('layouts.frontend');


			return view('schedules.details')
			->with('layout',$this->layout);
		} else { // THERE WAS NOT USER OR A GUEST SESSION GO BACK TO /SCHEDULE/NEW
			return Redirect::to('/schedule/new');
		}

	}

	public function postDetails()
	{	
		return view('layouts.frontend');
		//GET ALL THE INPUTS
		$inputs = Input::only('estimate_or_order','house_or_store','estimate_date','cleaning_date','_token');

		$estimate_or_order = $inputs['estimate_or_order'];
		$house_or_store = $inputs['house_or_store'];
		$estimate_date = $inputs['estimate_date'];
		$cleaning_date = $inputs['cleaning_date'];

		//IF USER WAS SIGNED IN GET ID, IF NOT GET THE ADDRESS INFORMATION FROM SESSION
		if(Auth::check()){//USER IS SIGN-IN
			//MEMBER
			$users = User::find(Auth::user()->id);
			/**
			* STATUS 1 = FORM COMPLETE, 
			*        2 = FORM INCOMPLETE(FRONTEND),
			*		 3 = SCHEDULE CANCELLED
			*		 4 = SCHEDULE COMPLETED
			**/

			$schedules = [];
			$schedules['user_id'] = Auth::user()->id;
			$schedules['firstname'] = Auth::user()->firstname;
			$schedules['lastname'] = Auth::user()->lastname;
			$schedules['email'] = Auth::user()->email;
			$schedules['phone'] = Auth::user()->phone;
			$schedules['street'] = Auth::user()->street;
			$schedules['unit'] = Auth::user()->unit;
			$schedules['city'] = Auth::user()->city;
			$schedules['state'] = Auth::user()->state;
			$schedules['zipcode'] = Auth::user()->zipcode;
			//
			$schedules['status'] = 3;
			//

			//ESTIMATE OR CLEANING 
			switch ($estimate_or_order) {
				case 1://ESTIMATE
					$schedules['type'] = 1;
					$schedules['pickup_date'] = date("Y-m-d H:i:s",strtotime($estimate_date));
					$schedules['place'] = $house_or_store;
					break;
				case 2://CLEANING
					$schedules['type'] = 2;
					$schedules['pickup_date'] = date("Y-m-d H:i:s",strtotime($cleaning_date));
					$schedules['place'] = $house_or_store;
					break;
				default:
					# code...
					break;
			}


			//SAVE ALL THE INFORMATION INTO THE SESSION
			Session::put('confirmation_data', $schedules);

		} else if(Session::get('guest_info')) {
			//GUEST

			$session_inputs = Session::get('guest_info');
			/**
			* STATUS 1 = FORM COMPLETE, 
			*        2 = FORM INCOMPLETE(FRONTEND),
			*		 3 = SCHEDULE CANCELLED
			*		 4 = SCHEDULE COMPLETED
			**/

			$schedules = [];
			$schedules['user_id'] = null;
			$schedules['firstname'] = $session_inputs['first_name'];
			$schedules['lastname'] = $session_inputs['last_name'];
			$schedules['email'] = $session_inputs['email'];
			$schedules['phone'] = $session_inputs['phone'];
			$schedules['street'] = $session_inputs['street'];
			$schedules['unit'] = $session_inputs['unit'];
			$schedules['city'] = $session_inputs['city'];
			$schedules['state'] = $session_inputs['state'];
			$schedules['zipcode'] = $session_inputs['zipcode'];
			//
			$schedules['status'] = 3;
			//

			//ESTIMATE OR CLEANING 
			switch ($estimate_or_order) {
				case 1://ESTIMATE
					$schedules['type'] = 1;
					$schedules['pickup_date'] = date("Y-m-d H:i:s",strtotime($estimate_date));
					$schedules['place'] = $house_or_store;
					break;
				case 2://CLEANING
					$schedules['type'] = 2;
					$schedules['pickup_date'] = date("Y-m-d H:i:s",strtotime($cleaning_date));
					$schedules['place'] = $house_or_store;
					break;
				default:
					# code...
					break;
			}

			//SAVE ALL THE INFORMATION INTO THE SESSION
			Session::put('confirmation_data', $schedules);

		} else { //SOMTHING WENT WRONG NEITHER USER NOR GUEST
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again. items and inventories')
			->with('alert_type','alert-danger');	
		}

		return Redirect::action('SchedulesController@getConfirmation');
	}

	public function getConfirmation()
	{
		return view('layouts.frontend');
		return view('schedules.confirmation')
		->with('layout',$this->layout);
	}

	public function postConfirmation()
	{

	}

	public function postDelete()
	{
		$id = Input::get('schedule_id');
		$schedules = Schedule::find($id);
		if($schedules->delete()) {
			return Redirect::action('SchedulesController@getIndex')
			->with('message', 'Successfully deleted!')
			->with('alert_type','alert-success');
		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}

	public function postOrderAdd()
	{
		if (Request::ajax()) {
			$status = 400;
			$count  = Input::get('content_set_count');
			$count_form  = Input::get('count_form');
			$html   = Schedule::prepareOrderForm($count,$count_form);
			return Response::json(array(
				'status' => 200,
				'html' => $html
				));
		}
	}
	public function postAjaxValidation() {
		if(Request::ajax()) {
			
			$value = Input::get('value');
			$type = Input::get('type');

			//CREATE ARRAY FOR VALIDATION
			$inputs =  array($type => $value);

			//VALIDATION
			$data = Job::AjaxValidation($inputs,$type);

			return Response::json(array(
				'data' => $data,
				));
		}
	}
}