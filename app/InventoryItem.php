<?php

class InventoryItem extends \Eloquent {
	protected $fillable = [];
	use SoftDeletingTrait;
		public static $rules_edit = array(
		'name'=>'required|min:1'
		);
	public static $rules_add = array(
		'name'=>'required|min:1',
		'description'=>'required|min:1',
		'inventory_id' => 'required|min:1',
		'price' => 'required|min:1|numeric'
		);

	public static function prepareInventoryItems($data) {
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$company_name = Company::where('id',$data[$key]['company_id'])->pluck('name');
				$inventories = Inventory::find($data[$key]['inventory_id']);
				$data[$key]['inventory_name'] = '';
				if ($inventories->name) {
					$data[$key]['inventory_name'] = $inventories->name;
				}
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
	  public static function prepareForSelect($data) {
        $data_output = array(''=>'Select Inventory');
        if(isset($data)) {
            foreach ($data as $key => $value) {
                $this_id = $value['id'];
                $this_name = $value['name'];
                $data_output[$this_id] = $this_name;
            }
        }
        return  $data_output;
    }
}