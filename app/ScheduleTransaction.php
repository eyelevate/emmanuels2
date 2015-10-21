<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleTransaction extends Model
{
	public static function prepareScheduleT($data) {
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
}
