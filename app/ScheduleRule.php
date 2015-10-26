<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class ScheduleRule extends Model {
	protected $fillable = [];

	public static function PreparedHoursForFullcalendar($rules,$start_date,$end_date) {
		$data = null;
		$calendar_prepared = null;
		if(isset($rules,$start_date,$end_date)) {
			$start_data_ts = strtotime($start_date);
			$end_data_ts = strtotime($end_date);
			for ($i=$start_data_ts; $i <= $end_data_ts  ; $i+=86400) { 
				$key = date('Y-m-d', $i);
				$data[$key] = [];
			}
			//PASS THE DATA TO NEXT STEP
			$returned_rules = ScheduleRule::SetRules($data,$rules);
			$calendar_prepared = ScheduleRule::PrepareCalendar($returned_rules);
		}
		return $calendar_prepared;
	}
	private static function SetRules($data,$rules) {
		if (isset($data,$rules)) {
			$weekly_schedule = json_decode($rules['weekly_schedule']);
			$blackoutdates = json_decode($rules['blackout_dates']);
			$balckoutdates_reformated = ScheduleRule::DateToYmdFormat($blackoutdates);
			foreach ($data as $dkey => $dvalue) {
				$new_numeric_day = null;
				$this_data_ts = strtotime($dkey);
				$this_day_numeric = date('N',$this_data_ts);
				$new_numeric_day = $this_day_numeric==7?0:$this_day_numeric;
				$is_blackout = false;
				foreach ($balckoutdates_reformated as $bdkey => $bdvalue) {
					if ($bdvalue == $dkey) {
						$is_blackout = true;
					}
				}
				$data[$dkey]['day'] = date('D',$this_data_ts);
				$data[$dkey]['open'] = $weekly_schedule[$new_numeric_day]->open;
				$data[$dkey]['blackout'] = $is_blackout;
				if ($is_blackout == false && $data[$dkey]['open'] == 'open') {
					$data[$dkey]['scheduels'] = $weekly_schedule[$new_numeric_day];
				}
			}
		}
		return $data;
	}
	private static function PrepareCalendar($data) {
		if (isset($data)) {
			$events = [];
			$counter = 0;
			$break_size = 0;

			foreach ($data as $dkey => $dvalue) {
				// Job::dump($dvalue);
				if ($dvalue['open'] == 'open' && $dvalue['blackout'] == false) {

					if (isset($dvalue['scheduels'],$dvalue['scheduels']->breaks)) {
						$break_size = 0;
						foreach ($dvalue['scheduels']->breaks as $bskey => $bsvalue) {
							$break_size++;
						}
					}

					if ($break_size > 0) {
						$events[$counter] =  [ // put the array in the `events` property
							'title' => ''.$dvalue['scheduels']->open_hour.':'.$dvalue['scheduels']->open_minute.$dvalue['scheduels']->open_ampm.
										' to '.$dvalue['scheduels']->close_hour.':'.$dvalue['scheduels']->close_minute.$dvalue['scheduels']->close_ampm,
							'start' => $dkey
						];
						for ($i=0; $i <= $break_size; $i++) { 

							$events[$counter.'b'] =  [ // put the array in the `events` property
							'title' => 'Break From '.$dvalue['scheduels']->open_hour.':'.$dvalue['scheduels']->open_minute.$dvalue['scheduels']->open_ampm.
										' to '.$dvalue['scheduels']->close_hour.':'.$dvalue['scheduels']->close_minute.$dvalue['scheduels']->close_ampm,
							'start' => $dkey,
							'color' => 'orange'
							];

							$counter++;
						}
					} else {
						$events[$counter] =  [ // put the array in the `events` property
							'title' => ''.$dvalue['scheduels']->open_hour.':'.$dvalue['scheduels']->open_minute.
										' to '.$dvalue['scheduels']->close_hour.':'.$dvalue['scheduels']->close_minute,
							'start' => $dkey
						];
					}


				} elseif ($dvalue['blackout'] == true) {
						$events[$counter] =  [ // put the array in the `events` property
							'title' => 'Blackout Day',
							'start' => $dkey,
							'color' => 'black'
						];
				}
				


				$counter++;
			}

		}
		$new_events = array_values($events);
		return $new_events;
	}


	private static function DateToYmdFormat($date) {
		if (isset($date)) {
			foreach ($date as $key => $value) {

				//this is how we fix the date time issue
				$t = date_create_from_format("D, d M, Y",$value);
				$value_reformated = date_format($t,"Y-m-d");
				//--------

				$date->$key = $value_reformated;

			}
		}
		return $date;
	}







	public static $rules_add = array(
		
		);

	public static function prepareSchedules($data) {
		if(isset($data)) {
			foreach ($data as $key => $value) {

				if(isset($data[$key]['status'])) {
					switch($data[$key]['status']) {
						case 1:
						$data[$key]['status_html'] = '<span class="label label-success">Active</span>';
						break;

						case 2:
						$data[$key]['status_html'] = '<span class="label label-warning">Deleted</span>';
						break;

						case 3:
						$data[$key]['status_html'] = '<span class="label label-danger">errors</span>';
						break;
					}
				}
			}
		}
		return $data;
	}



	public static function PrepareForEdit($data) {
		if(isset($data)) {

			if(isset($data['status'])) {
				switch($data['status']) {
					case 1:
					$data['status_html'] = '<span class="label label-success">Active</span>';
					break;

					case 2:
					$data['status_html'] = '<span class="label label-warning">Deleted</span>';
					break;

					case 3:
					$data['status_html'] = '<span class="label label-danger">errors</span>';
					break;
				}
			}

			if(isset($data['schedule_time'])) {

				$data['schedule_time_de'] = json_decode($data['schedule_time']);

			}

			if(isset($data['weekly_schedule'])) {
				$data['weekly_schedule_de'] = json_decode($data['weekly_schedule']);



				foreach ($data['weekly_schedule_de'] as $wskey => $wsvalue) {
					$break_count = 0;
					$badge_count = 0;
					$day_id = $wskey;
					$wsvalue->breaks_html = '';
					if (isset($wsvalue->breaks)) {

						foreach ($wsvalue->breaks as $wbkey => $wbvalue) {
							$break_count++;
							$badge_count++;
							$from_hour = $wbvalue->from_hour;
							$from_minute = $wbvalue->from_minute;
							$from_ampm = $wbvalue->from_ampm;
							$to_hour = $wbvalue->to_hour;
							$to_minute = $wbvalue->to_minute;
							$to_ampm = $wbvalue->to_ampm;



							$wsvalue->breaks_html .= '<div class="alert alert-info alert-dismissible br-alert" style="margin-bottom: 1px;"
							role="alert"><button type="button" class="close" data-dismiss="alert" 
							aria-label="Close"><span aria-hidden="true">&times;</span></button> 
							<span class="badge b-badge">'.$badge_count.'</span>&nbsp&nbspFrom&nbsp
							&nbsp'.$from_hour.':'.$from_minute.''.$from_ampm.'&nbsp&nbspTo&nbsp
							&nbsp'.$to_hour.':'.$to_minute.''.$to_ampm;


							$wsvalue->breaks_html .= '<input name="hours['.$day_id.'][breaks]['.$break_count.'][from_hour]" type="hidden" value="'.$from_hour.'">';

							$wsvalue->breaks_html .= '<input name="hours['.$day_id.'][breaks]['.$break_count.'][from_minute]" type="hidden" value="'.$from_minute.'">';

							$wsvalue->breaks_html .= '<input name="hours['.$day_id.'][breaks]['.$break_count.'][from_ampm]" type="hidden" value="'.$from_ampm.'">';

							$wsvalue->breaks_html	.= '<input name="hours['.$day_id.'][breaks]['.$break_count.'][to_hour]" type="hidden" value="'.$to_hour.'">';

							$wsvalue->breaks_html .= '<input name="hours['.$day_id.'][breaks]['.$break_count.'][to_minute]" type="hidden" value="'.$to_minute.'">';

							$wsvalue->breaks_html .= '<input name="hours['.$day_id.'][breaks]['.$break_count.'][to_ampm]" type="hidden" value="'.$to_ampm.'">';
							
							$wsvalue->breaks_html .= '</div>';

						}
					}


				}

				

			}



			if(isset($data['blackout_dates'])) {

				$data['blackout_dates_de'] = json_decode($data['blackout_dates']);
				$data['blackout_dates_html'] = '';

				if (isset($data['blackout_dates_de'])) {
					foreach ($data['blackout_dates_de'] as $bdkey => $bdvalue) {
						$data['blackout_dates_html'] .= '<div class="blackout-single-wrapper">' .
						'<div class="alert alert-danger alert-style blackout-date clearfix" id="blackout-'.$bdkey.'" role="alert" >' .
						'<span class="badge">' . $bdkey . '</span>' .
						'   ' . $bdvalue .
						'<a class="btn btn-danger btn-sm pull-right blackout-remove-btn" id="remove-blackout-' . $bdkey . '" >Remove</a>' .
						'</div>' .
						'<input type="hidden" name="blackoutdates[' . $bdkey . ']" alert_id="blackout-'.$bdkey.'"  class="blackout-form"  value="' . $bdvalue . '">' .
						'</div>';
					}
				}
			}
			if(isset($data['zipcodes'])) {

				$data['zipcodes_de'] = json_decode($data['zipcodes']);
				$data['zipcodes_html'] = '';

				if (isset($data['zipcodes_de'])) {
					foreach ($data['zipcodes_de'] as $zkey => $zvalue) {
						$data['zipcodes_html'] .= '<span class="label label-success label-area '.$zvalue.'" > <span class="this-area-t">'.$zvalue.'</span> <i class="glyphicon glyphicon-trash delete-area"></i></span>';
						$data['zipcodes_html'] .= '<input class="'.$zvalue.'" type="hidden" name="areas['.$zkey.$zvalue.']" value="'.$zvalue.'" >';
					}
				}
			}
		}

		return $data;
	}


	public static function PrepareForSelect($data ) {
		$schedules = array(''=>'Select An Schedule');
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$id = $value['id'];
				$title = $value['title'];
				$schedules[$id] = $title; 
			}
		}
		return $schedules;
	}
}