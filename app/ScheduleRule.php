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
			
			$prepare_rules = ScheduleRule::PrepareRules($rules);
			$prepared_hourly_rules = ScheduleRule::PrepareHourlyRules($prepare_rules);
			//ADD OVERWRITE HERE
			$returned_rules = ScheduleRule::SetRules($data,$prepared_hourly_rules,$prepare_rules);
			$calendar_prepared = ScheduleRule::PrepareCalendar($returned_rules);
		}
		return $calendar_prepared;
	}

	private static function PrepareCalendar($data) {
		if (isset($data)) {
			$events = [];
			
			foreach ($data as $dkey => $dvalue) {
				$h_key = 0;
				$now_time = date("H:i:s");
				$key_preapred = $dkey.' '.$now_time;
				$key_strtotime = strtotime($key_preapred);
				if (isset($dvalue['weekly_schedule'])) {
					foreach ($dvalue['weekly_schedule'] as $wskey => $wsvalue) {
						$h_key++;
						$start_time = date('H:ia', $wsvalue['start']);
						$end_time = date('H:ia', $wsvalue['end']);
						$color = $wsvalue['color'];



						$events[$key_strtotime.$h_key] =  [ // put the array in the `events` property
									'title' => $start_time.'-'.$end_time,
									'start' => $dkey,
									'color' => $color
								];

					}
				}
			}
		}
		// Job::dump($events);
		$new_events = array_values($events);
		return $new_events;
	}

	private static function PrepareHourlyRules($prepare_rules) {
		$full_schedule = [];
		if (isset($prepare_rules)) {
				foreach ($prepare_rules['weekly_schedule'] as $wskey => $wsvalue) {
					if ($prepare_rules['weekly_schedule'][$wskey]['open'] == true) {
						$open_time = $prepare_rules['weekly_schedule'][$wskey]['open_time'];
						$close_time = $prepare_rules['weekly_schedule'][$wskey]['close_time'];
						$key = 0;

						for ($i=$open_time; $i <= $close_time; $i+=$prepare_rules['time_per_service']) { 
							$key++;
							$start_hour = $i;
							$end_hour = $i + $prepare_rules['time_per_service'];


								$full_schedule[$wskey][$start_hour] = [
										//place in schedule_rules / schedules_transactions
										'key'=> $key,
										'start'=>$start_hour,
										'end'=>$end_hour,
										'schedule_count' => 2,
										'drivers' => 3,
										'color'=>'green'
									];
						}
						if (isset($wsvalue['breaks'])) {
							foreach ($wsvalue['breaks'] as $wsbkey => $wsbvalue) {
								$full_schedule[$wskey][$wsbvalue['start']] = [
										'start'=>$wsbvalue['start'],
										'end'=>$wsbvalue['end'],
										'schedule_count' => 2,
										'drivers' => 3,
										'color'=>'gray'
									];
							}
						}
					}
				}
			// sort schedule by timestamp
			foreach($full_schedule as $fskey => $fsvalue){
				ksort($full_schedule[$fskey]);
			}
		}
		return $full_schedule;
		
	}

	private static function SetRules($data,$prepared_hourly_rules,$pre_prepared_rules) {
		if (isset($data,$prepared_hourly_rules,$pre_prepared_rules)) {
			foreach ($data as $dkey => $dvalue) {
				$is_blackout = false;
				if (isset($pre_prepared_rules['blackout_dates']) && !empty($pre_prepared_rules['blackout_dates'])) {
					foreach ($pre_prepared_rules['blackout_dates'] as $bodkey => $bodvalue) {
						$bod_date = date('Y-m-d',$bodvalue);
						// $is_blackout = $bod_date == $dkey ? true : false;
						if ($bod_date == $dkey) {
							$is_blackout = true;
						}
					}
				}

				if ($is_blackout == false) {
					$now_time = date("H:i:s");
					$key_preapred = $dkey.' '.$now_time;
					$key_strtotime = strtotime($key_preapred);
					$this_day_numeric = date('w',$key_strtotime);
					$data[$dkey]['day'] = date('D',$key_strtotime);
					$data[$dkey]['blackoutdates'] = false;
					if (isset($prepared_hourly_rules[$this_day_numeric])) {
						$data[$dkey]['weekly_schedule'] = $prepared_hourly_rules[$this_day_numeric];
					}

				} else {
					$now_time = date("H:i:s");
					$key_preapred = $dkey.' '.$now_time;
					$key_strtotime = strtotime($key_preapred);
					$data[$dkey]['day'] = date('D',$key_strtotime);
					$data[$dkey]['blackoutdates'] = true;
				}
			}
		}
		return $data;
	}


	private static function PrepareRules($rules) {
		
		$prepared_rules_array = [];

		$scheduel_time_array = json_decode($rules['schedule_time'],true);
		$schedule_time_hour = $scheduel_time_array['hour'];
		$schedule_time_minute = $scheduel_time_array['minute'];
		$scheduel_time_inseconds = ScheduleRule::HMtoS($schedule_time_hour,$schedule_time_minute);
		$prepared_rules_array['time_per_service'] = $scheduel_time_inseconds;

		//###############
		$blackout_dates_array = json_decode($rules['blackout_dates'],true);
		$prepared_blackout_dates_array = [];
		foreach ($blackout_dates_array as $bdakey => $bdavalue) {
				$t = date_create_from_format("D, d M, Y",$bdavalue);
				$value_reformated = date_format($t,"Y-m-d H:i:s");
				$prepared_blackout_dates_array[$bdakey] = strtotime($value_reformated);
		}
		$prepared_rules_array['blackout_dates'] = $prepared_blackout_dates_array;
		//###############

		$prepared_weekly_schedule_array = [];
		$weekly_scheduel_array = json_decode($rules['weekly_schedule'],true);
		$today_date = date("Y-m-d");
		foreach ($weekly_scheduel_array as $wskey => $wsvalue) {
			$prepared_breaks_array = [];
			$prepared_weekly_schedule_array[$wskey]['open'] = $wsvalue['open']=='open'?true:false;
			if ($prepared_weekly_schedule_array[$wskey]['open'] == true) {
				$prepared_weekly_schedule_array[$wskey]['open_time'] = strtotime($today_date.' '.$wsvalue['open_hour'].':'.$wsvalue['open_minute'].$wsvalue['open_ampm']);
				$prepared_weekly_schedule_array[$wskey]['close_time'] = strtotime($today_date.' '.$wsvalue['close_hour'].':'.$wsvalue['close_minute'].$wsvalue['close_ampm']);
				//BREAKS
				if (isset($wsvalue['breaks'])) {
					foreach ($wsvalue['breaks'] as $wsbkey => $wsbvalue) {
						$prepared_breaks_array[$wsbkey]['start'] = strtotime($today_date.' '.$wsbvalue['from_hour'].':'.$wsbvalue['from_minute'].$wsbvalue['from_ampm']);
						$prepared_breaks_array[$wsbkey]['end'] = strtotime($today_date.' '.$wsbvalue['to_hour'].':'.$wsbvalue['to_minute'].$wsbvalue['to_ampm']);
					}
					$prepared_weekly_schedule_array[$wskey]['breaks'] = $prepared_breaks_array;
				}
			}
		}
		$prepared_rules_array['weekly_schedule'] = $prepared_weekly_schedule_array;

		return $prepared_rules_array;
	}

	private static function HMtoS($hr,$min) {
		return $hr * 3600 + $min * 60;
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