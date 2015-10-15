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

		public static $rules_add = array(
		'title'=>'required|min:1',
		'schedules-select'=>'required',
		
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
					
				}
				if(isset($data['blackout_dates'])) {

					$data['blackout_dates_de'] = json_decode($data['blackout_dates']);
					$data['blackout_dates_html'] = '';

					foreach ($data['blackout_dates_de'] as $bdkey => $bdvalue) {
				    $data['blackout_dates_html'] .= '<div class="blackout-single-wrapper">' .
				            '<div class="alert alert-danger alert-style blackout-date clearfix" id="blackout-'.$bdkey.'" role="alert" >' .
				            '<span class="badge">' . $bdkey . '</span>' .
				            '   ' . $bdvalue .
				            '<a class="btn btn-danger btn-sm pull-right " id="remove-blackout-' . $bdkey . '" >Remove</a>' .
				            '</div>' .
				            '<input type="hidden" name="blackoutdates[' . $bdkey . ']" alert_id="blackout-'.$bdkey.'"  class="blackout-form"  value="' . $bdvalue . '">' .
				            '</div>';
					}
					
				}
				if(isset($data['zipcodes'])) {

					$data['zipcodes_de'] = json_decode($data['zipcodes']);
					$data['zipcodes_html'] = '';

					foreach ($data['zipcodes_de'] as $zkey => $zvalue) {
						$data['zipcodes_html'] .= '<span class="label label-success label-area '.$zvalue.'" > <span class="this-area-t">'.$zvalue.'</span> <i class="glyphicon glyphicon-trash delete-area"></i></span>';
						$data['zipcodes_html'] .= '<input class="'.$zvalue.'" type="hidden" name="areas['.$zkey.$zvalue.']" value="'.$zvalue.'" >';
					}

					
				}
		}
		return $data;
	}
}