<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Tax extends Model {
	protected $fillable = [];
	public static $rules = array(
	    'zipcode'=>'required|numeric|min:2',
	    'city'=>'required|alpha|min:2',
	    'state'=>'required|alpha|min:2',
	    'country'=>'required|alpha|min:2',
	    'rate'=>'required|numeric'
	);

	public static function prepareForView($data) {
		if(isset($data)) {
			foreach($data as $key => $value) {
				if(isset($data[$key]['city'])) {
					$data[$key]['city'] = ucfirst($data[$key]['city']);
				}
				if(isset($data[$key]['state'])) {
					$data[$key]['state'] = ucfirst($data[$key]['state']);
				}
				if(isset($data[$key]['rate'])) {
					$data[$key]['rate'] = Job::formatDollar($data[$key]['rate']);
				}
				if(isset($data[$key]['status'])) {
					switch ($data[$key]['status']) {
						case 1:// Created by user
						$data[$key]['status_html'] = '<span class="label label-primary">Created</span>';
						break;
						case 2:// Accepted by owner
						$data[$key]['status_html'] = '<span class="label label-info">Accepted</span>';
						break;
						case 3:// In-process
						$data[$key]['status_html'] = '<span class="label label-info">In Process</span>';
						break;
						case 4:// In-delivery
						$data[$key]['status_html'] = '<span class="label label-info">In Delivery</span>';
						break;
						case 5:// Completed
						$data[$key]['status_html'] = '<span class="label label-success">Completed</span>';
						break;
						case 6:// Cancelled
						$data[$key]['status_html'] = '<span class="label label-default">Cancelled</span>';
						break;					
						default://errors
						$data[$key]['status_html'] = '<span class="label label-danger">Error</span>';
						break;
					}
				}
			}
		}

		return $data;
	}

		public static function taxStatus()
	{
		return array(
			'' => 'Select Status',
			'1'	=> 'Active'
			);
	}


}