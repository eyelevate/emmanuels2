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
class ScheduleLimitsController extends Controller {

	//set layout
	protected $layout = "layouts.admin";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct() {
		// Set protection
		$this->beforeFilter('csrf', array('on'=>'post'));


		// Check if user is authorized to view the page
		$routes = explode("@", Route::currentRouteAction(), 2);     
        $this->controller = strtolower(str_replace('Controller', '', $routes[0]));
        $this->method = $routes[1];
        $this->parameters = Route::current()->parameters();

		// Set the layout
		switch(Auth::user()->roles){
			case 2:
				$this->layout = "layouts.admin";
			break;
			case 3:
				$this->layout = "layouts.admin_owner";
			break;
			case 4:
				$this->layout = "layouts.admin_employees";
			break;
			case 5:
				$this->layout = "layouts.admin_members";
			break;
			case 6:
				$this->layout = "layouts.admin";
			break;
		}
     	// Page content setup
        $this->company_id = 1;
        $role_id = (isset($member_id)) ? Auth::user()->roles : null;
        $role_name = Admin::getRoleName($role_id);
	
        View::share('role',$role_name);
       	View::share('controller',$this->controller);
		View::share('action',$this->method);
	}

	public function getIndex()
	{

		//SCHEDULE LIMITS
		$schedule_limits = ScheduleLimit::get();
		$limits_array = null;
		if (isset($schedule_limits)) {
			foreach ($schedule_limits as $lkey => $lvalue) {
			
			$limits_array[$lkey]['open'] = $lvalue['state']==1?'open':'close';

			$open_date =  $lvalue['schedule_hours_open'];
			$close_date =  $lvalue['schedule_hours_close'];

			$limits_array[$lkey]['open_hour'] = date('H',strtotime($open_date));
			$limits_array[$lkey]['open_minute'] = date('i',strtotime($open_date));
			$limits_array[$lkey]['open_ampm'] = date('a',strtotime($open_date));
			$limits_array[$lkey]['close_hour'] = date('H',strtotime($close_date));
			$limits_array[$lkey]['close_minute'] = date('i',strtotime($close_date));
			$limits_array[$lkey]['close_ampm'] = date('a',strtotime($close_date));
			}
		}

		//SCHEDULE OVERWRITE
		$schedule_overwrites = ScheduleOverwrite::get();
		$overwrite_array = null;
		if (isset($schedule_overwrites)) {
			foreach ($schedule_overwrites as $okey => $ovalue) {
				// TYPE 1 = SINGLE, TYPE 2 = RANGE
				if ($ovalue['type'] == 1) {//SINGLE
					$date =  $ovalue['overwrite_date'];
					$open =  $ovalue['overwrite_date'];
					$close =  $ovalue['overwrite_date'];
					$overwrite_array[$okey]['type'] = $ovalue['type'] == 1?'single':'range';
				} else{//RANGE
					$overwrite_array[$okey]['type'] = $ovalue['type'] == 1?'single':'range';
				}
			}
		}
		
		Job::dump($overwrite_array);
		$this->layout->content = View::make('schedule_limits.index');
	}
	public function postIndex()
	{	
		$today = date('Y-m-d');

		//SCHEDULE LIMITS START **
		$hours_array = Input::get('hours');
		foreach ($hours_array as $hkey => $hvalue) {
			$schedule_limits = new ScheduleLimit;
			if ($hvalue['open'] == "open") {
				$open_hours = strtotime($today.' '.$hvalue['open_hour'].':'.$hvalue['open_minute'].' '.$hvalue['open_ampm']);
				$close_hours = strtotime($today.' '.$hvalue['close_hour'].':'.$hvalue['close_minute'].' '.$hvalue['close_ampm']);
				// FINAL PRODUCT
				$open_date_formated = date('Y-m-d H:i:s',$open_hours);
				$close_date_formated = date('Y-m-d H:i:s',$close_hours);
				$schedule_limits->schedule_hours_open = $open_date_formated;
				$schedule_limits->schedule_hours_close = $close_date_formated;
				$schedule_limits->state = 1;//OPEN
				$schedule_limits->status = 1;
			} else {
				$schedule_limits->state = 2;//CLOSE
				$schedule_limits->status = 1;
			}

			//SAVE 
			$schedule_limits->save();
		}
		//SCHEDULE LIMITS END **


		//SCHEDULE OVERWRITE START **
		$overwrite = Input::get('overwrite');
		foreach ($overwrite as $okey => $ovalue) {
			
			//SINGLE
			if ($ovalue['type'] == "single") {
				$schedule_overwrite = new ScheduleOverwrite;
				//SET TYPE
				$schedule_overwrite->type = 1;

				$overwrite_data_strtotime = strtotime($ovalue['date']);
				//FINAL PRODUCT
				$overwrite_data_formated = date('Y-m-d',$overwrite_data_strtotime);
				$schedule_overwrite->overwrite_date = $overwrite_data_formated;

				$ow_open_hours = strtotime($today.' '.$ovalue['open_hour'].':'.$ovalue['open_minute'].' '.$ovalue['open_ampm']);
				$ow_close_hours = strtotime($today.' '.$ovalue['close_hour'].':'.$ovalue['close_minute'].' '.$ovalue['close_ampm']);
				//FINAL PRODUCT
				$ow_open_hours_formated = date('Y-m-d H:i:s',$ow_open_hours);
				$ow_close_hours_formated = date('Y-m-d H:i:s',$ow_close_hours);
				$schedule_overwrite->overwrite_hours_open = $ow_open_hours_formated;
				$schedule_overwrite->overwrite_hours_close = $ow_close_hours_formated;

				//NUMBER OF EMPLOYEE
				$number_of_employee = $ovalue['number_of_employee'];
				$schedule_overwrite->number_of_employee = $number_of_employee;
				// SAVE 
				$schedule_overwrite->save();

			} else if ($ovalue['type'] == "range"){//RANGE

				//OVERWRITE START
				$start_strtotime = strtotime($ovalue['start']);
				//OVERWRITE END
				$end_strtotime = strtotime($ovalue['end']); 
				for ($i=$start_strtotime; $i <= $end_strtotime; $i += 86400) {
					//CREATE NEW 
					$schedule_overwrite = new ScheduleOverwrite;
					//SET TYPE
					$schedule_overwrite->type = 2;

					$schedule_overwrite->overwrite_date = date('Y-m-d',$i);
					//OVERWRITE HOURS
					$ow_open_hours = strtotime($today.' '.$ovalue['open_hour'].':'.$ovalue['open_minute'].' '.$ovalue['open_ampm']);
					$ow_close_hours = strtotime($today.' '.$ovalue['close_hour'].':'.$ovalue['close_minute'].' '.$ovalue['close_ampm']);
					//FINAL PRODUCT
					$ow_open_date_formated = date('Y-m-d H:i:s',$ow_open_hours);
					$ow_close_date_formated = date('Y-m-d H:i:s',$ow_close_hours);
					$schedule_overwrite->overwrite_hours_open = $ow_open_date_formated;
					$schedule_overwrite->overwrite_hours_close = $ow_close_date_formated;

					//NUMBER OF EMPLOYEE
					$number_of_employee = $ovalue['number_of_employee'];
					$schedule_overwrite->number_of_employee = $number_of_employee;
					// SAVE 
					$schedule_overwrite->save();
				}
			}
		}
		//SCHEDULE OVERWRITE END **


		//SCHEDULE BLACKOUT START **
		$blackouts = Input::get('blackoutdates');
		foreach ($blackouts as $bkey => $bvalue) {
			$schedule_blackout = new ScheduleBlackout;
			$blackout_dates = date('Y-m-d',strtotime($bvalue));
			$schedule_blackout->blackout_date = $blackout_dates;
			$schedule_blackout->status = 1;
			$schedule_blackout->save();
		}
		//SCHEDULE BLACKOUT END **


	}

	public function getAdd()
	{
		$this->layout->content = View::make('schedule_rules.add');
	}
	public function postAdd()
	{
		
	}

	public function getEdit($id = null)
	{
		$this->layout->content = View::make('schedule_rules.edit');
	}
	public function postEdit()
	{
		
	}

	public function postDelete()
	{
		
	}

	public function postAddOverwrite() {
		if(Request::ajax()) {
			$current_count = Input::get('count');
			$html = ScheduleLimit::prepareNewOverwrite($current_count);

			return Response::json(array(
				'html' => $html,
				));
		}
	}
	

	public function postValidateHours() {
		if(Request::ajax()) {
			$data = Input::get('data');

			$validation_result = ScheduleLimit::prepareValidationResults($data);

			return Response::json(array(
				'validation_result' => $validation_result,
				));
		}
	}

	public function postValidateOverWriteHours() {
		if(Request::ajax()) {
			$data = Input::get('data');
			$validation_result = ScheduleLimit::prepareValidationOverWriteResults($data);
			return Response::json(array(
				'validation_result' => $validation_result,
				));
		}
	}

}