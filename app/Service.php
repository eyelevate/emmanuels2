<?php

class Service extends \Eloquent {
	protected $fillable = [];
	use SoftDeletingTrait;
	public static $rules_edit = array(
		'name'=>'required|min:1'
		);
	public static $rules_add = array(
		'name'=>'required|min:1',
		'description'=>'required|min:1',
		'rate' => 'required|min:1|numeric',
		'type' => 'required'
		);

	public static function prepareServices($data) {
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$inventory_items_count =count(InventoryItem::where('inventory_id',$data[$key]->id)->get());
				$company_name = Company::where('id',$data[$key]['company_id'])->pluck('name');
				$data[$key]['item_count'] = $inventory_items_count;
				$data[$key]['company_name'] = $company_name;
				if(isset($data[$key]['status'])) {
					switch($data[$key]['status']) {
						case 1:
						$data[$key]['status_html'] = '<span class="label label-success">active</span>';
						break;

						case 2:
						$data[$key]['status_html'] = '<span class="label label-warning">not active</span>';
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
		public static function prepareTypes() {
		$types = array(
			''=>'Select Types',
			'1'=>'Cleaning',
			'2'=>'Sales',
			'3'=>'---'
			);
		return $types;
	}
}