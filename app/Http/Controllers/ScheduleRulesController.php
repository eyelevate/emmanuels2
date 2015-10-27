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
use App\Schedule;
use App\ScheduleLimit;
use App\ScheduleOverwrite;
use App\Delivery;
use App\ScheduleRule;



class ScheduleRulesController extends Controller {
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
		$schedules = ScheduleRule::prepareSchedules(ScheduleRule::get());


		return view('schedule_rules.index')
			->with('layout',$this->layout)
			->with('schedules',$schedules);
	}

	public function getAdd($id = null)
	{
		$schedule_select = Schedule::PrepareForSelect();
		return view('schedule_rules.add')
		->with('layout',$this->layout)
		->with('schedule_select',$schedule_select)
		->with('s_id',$id);
	}
	public function postAdd()
	{
			$validator = Validator::make(Input::all(), ScheduleRule::$rules_add);
			if ($validator->passes()) {
				$rules = new ScheduleRule;
				$rules->schedule_id = Input::get('schedules-select');
				$rules->title = Input::get('title');
				$rules->description = Input::get('description');
				$rules->schedule_time = json_encode(Input::get('schedule_time'));
				$rules->weekly_schedule = json_encode(Input::get('hours'));
				$rules->blackout_dates = json_encode(Input::get('blackoutdates'));
				$rules->zipcodes = json_encode(Input::get('areas'));
				$rules->status = 1;

				if ($rules->save()) {
					return Redirect::route('rules_index');
				}

			} else {
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
			$schedule_rules = ScheduleRule::PrepareForEdit(ScheduleRule::find($id));
			$schedule_select = Schedule::PrepareForSelect();
			return view('schedule_rules.edit')
			->with('layout',$this->layout)
			->with('schedule_rules',$schedule_rules)
			->with('schedule_select',$schedule_select);
	}
	public function postEdit()
	{
		$validator = Validator::make(Input::all(), ScheduleRule::$rules_add);
			if ($validator->passes()) {

				$this_id = Input::get('this_id');
				$rules = ScheduleRule::find($this_id);
				$rules->schedule_id = Input::get('schedules-select');
				$rules->title = Input::get('title');
				$rules->description = Input::get('description');
				$rules->schedule_time = json_encode(Input::get('schedule_time'));
				$rules->weekly_schedule = json_encode(Input::get('hours'));
				$rules->blackout_dates = json_encode(Input::get('blackoutdates'));
				$rules->zipcodes = json_encode(Input::get('areas'));
				//  $rules->status = 1;

				if ($rules->save()) {
					return Redirect::route('rules_index');
				}

			} else {
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
		$id = Input::get('schedule_rules_id');
		$schedules = ScheduleRule::find($id);
		if($schedules->delete()) {
			return Redirect::action('ScheduleRulesController@getIndex')
			->with('message', 'Successfully deleted!')
			->with('alert_type','alert-success');
		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}

	public function postAddOverwrite() {
		if(Request::ajax()) {
			$current_count = Input::get('count');
			$html = ScheduleLimit::prepareNewOverwrite($current_count);
			return Response::json(array(
				'html' => $html
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

	public function postReturnRules() {
		if(Request::ajax()) {
			$id = Input::get('id');
			$this_data = Input::get('this_date_text');

			$this_date_timestamp = strtotime($this_data);
			$this_month = date("m", $this_date_timestamp);
			$this_year = date("Y", $this_date_timestamp);
			$last_day_of_this_month = date("t",$this_date_timestamp);

			$start_date = $this_year.'-'.$this_month.'-01';
			$end_date = $this_year.'-'.$this_month.'-'.$last_day_of_this_month;

			$rules = ScheduleRule::find($id);
			$data_for_fullcalendar = ScheduleRule::PreparedHoursForFullcalendar($rules,$start_date,$end_date);

    		return Response::json(array(
    			'status' => 200,
    			'events' => $data_for_fullcalendar
    		));
		}
	}
}