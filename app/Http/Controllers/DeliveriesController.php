<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\FundingInstrument;
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
class DeliveriesController extends Controller {
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
		$this->role_id = (isset(Auth::user()->roles)) ? Auth::user()->roles : null;
		
	}

	public function getIndex()
	{
		// //Clearing all sessions
		// if(Session::get('invoice_items')) Session::forget('invoice_items');
		// if(Session::get('invoice_items_edit')) Session::forget('invoice_items_edit');
		// if(Session::get('schedule_edit')) Session::forget('schedule_edit');
		// if(Session::get('schedule_add_session')) Session::forget('schedule_add_session');
		// if(Session::get('insert_range')) Session::forget('insert_range');

		if ($this->role_id < 3) {
			$companies = Company::find(1);
			$deliveries = Delivery::prepare(Delivery::where('status',1)->get());
			$this->layout->content = View::make('deliveries.index')
			->with('deliveries',$deliveries)
			->with('companies',$companies);
		}
	}

	public function getAdd()
	{
		$this->layout->content = View::make('deliveries.add');
	}
	public function postAdd()
	{
		
	}

	public function getEdit($id = null)
	{
		$this->layout->content = View::make('deliveries.edit');
	}
	public function postEdit()
	{
		
	}

	public function postDelete()
	{
		$delivery_id = Input::get('delivery_id');
		$delivery = Delivery::find($delivery_id);
		if($delivery->delete()) {
			return Redirect::action('DeliveriesController@getIndex')
			->with('message', 'Successfully deleted!')
			->with('alert_type','alert-success');
		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}

}