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
		return view('schedule_rules.index')
			->with('layout',$this->layout);
	}

	public function getAdd()
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
		
		return view('schedule_rules.add')
		->with('layout',$this->layout);
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
}