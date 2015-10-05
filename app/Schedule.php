<?php

class Schedule extends \Eloquent {
	protected $fillable = [];
	use SoftDeletingTrait;

	public static $rules_add = array(
		//DISABLED FOR NOW, UNTIL ADDING CONDITION FROM NEW ADDRESS
		// 'name'=>'required|min:1',
		// 'telephone'=>'required|min:1',
		// 'street'=>'required|min:1',
		// 'unit'=>'required|min:1',
		// 'city'=>'required|min:1',
		// 'state'=>'required|min:1',
		// 'zipcode'=>'required|min:1',
		);

		public static $schedules_add_frontend = array(
		'first_name'=>'required|min:1',
		'last_name'=>'required|min:1',
		'phone'=>'required|min:1',
		'email'=>'required|min:1',
		'street'=>'required|min:1',
		'unit'=>'required|min:1',
		'city'=>'required|min:1',
		'state'=>'required|min:1',
		'zipcode'=>'required|min:1',
		);


	public static function prepareSchedules($data) {
		if(isset($data)) {
			foreach ($data as $key => $value) {
				if(isset($data[$key]['type'])) {
					switch($data[$key]['type']) {
						case 0:
						$data[$key]['type'] = 'Work Order';
						break;

						case 1:
						$data[$key]['type'] = 'Estimate';
						break;
					}
				}

				if(isset($data[$key]['phone'])) {
					$data[$key]['phone'] = Job::format_phone($data[$key]['phone'],'US');
				}


				if(isset($data[$key]['pickup_date'])) {
					$data[$key]['pickup_date'] = date("l, d F, Y",strtotime($data[$key]['pickup_date']));
				}
				if(isset($data[$key]['delivery_date'])) {
					$data[$key]['delivery_date'] = date("l, d F, Y",strtotime($data[$key]['delivery_date']));
				}

				if(isset($data[$key]['created_at'])) {
					$data[$key]['created_html'] = date("l, d F, Y",strtotime($data[$key]['created_at']));
				}


				if(isset($data[$key]['street'],$data[$key]['street'],$data[$key]['unit'],$data[$key]['zipcode'],$data[$key]['city'])) {
					$data[$key]['address'] = $data[$key]['unit'].' '.$data[$key]['street'].', '.$data[$key]['city'].', '.$data[$key]['state'].', '.$data[$key]['zipcode'];
				}

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

	public static function prepareOrderForm($count,$count_form) {
		$services = Service::all();
		$inventories = Inventory::all();
		$inventory_items = InventoryItem::all();

		$html = '';
		$html .= '<div class="panel panel-success content-set" this_set="'.$count_form.'" style="margin-top:10px;">';

		$html .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
		$html .= 'data-parent="#accordion" href="#accordion-'.$count_form.'" aria-expanded="true" aria-controls="collapseOne"';
		$html .= 'style="cursor: pointer;">';
		$html .= '<h4 class="panel-title">';
		$html .= '<a class="this-title">';
		$html .= 'Order '.($count+1);
		$html .= '</a>';
		$html .= '<a>';
		$html .= '<i class="glyphicon glyphicon-chevron-down pull-right"></i>';
		$html .= '</a>';
		$html .= '</h4>';
		$html .= '</div>';
		//here is the bug
		$html .= '<div id="accordion-'.$count_form.'" this_set="'.$count_form.'" class="panel-collapse collapse in collapse-'.$count_form.'" role="tabpanel" aria-labelledby="headingOne">';
		$html .= '<div class="panel-body panel-input">';

		$html .= '	<div class="form-group">
		<div class="radio">
		<label>
		<input type="radio" class="radio-option " name="content_radio_'.$count_form.'" id="service-radio" value="1">
		Services
		</label>
		</div>
		<div class="radio " >
		<label>
		<input type="radio" class="radio-option" name="content_radio_'.$count_form.'" id="item-radio" value="2">
		Items
		</label>
		</div>
		</div>';

		//RADIO ERROR
		$html .= '<span class="radio-error help-block hide" style="color:#a94442;">Please complete the order</span>';

		$html .= '<div class="form-group form-group-make hide make-form-'.$count_form.' ">';
		$html .= '<label class="control-label" for="make">MAKE</label>';
		$html .= '<select class="form-control select-make" status="" name="select-make-'.$count_form.'" id="select-make-'.$count_form.'">';
		$html .= '<option value="">Select Service</option>';
		foreach ($services as $key => $value) {
			$html .=	'<option value="'.$value->id.'" rate="'.$value->rate.'">'.$value->name.'</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		//MAKE ERROR
		$html .= '<span class="make-error help-block hide" style="color:#a94442;">Service must be selected!</span>';


		$html .= '<div class="form-group form-group-item hide item-form-'.$count_form.'">';
		$html .= '<label class="control-label" for="item">ITEM</label>';
		$html .= '<select class="form-control select-item" status="" name="select-item-'.$count_form.'" id="select-item-'.$count_form.'">';
		$html .= '<option value="">Select Item</option>';
		foreach ($inventories as $key => $value) {
			$html .= '<optgroup label='.$value->name.'>';
			foreach ($inventory_items as $ikey => $ivalue) {
				if ($ivalue->inventory_id == $value->id) {
					$html .=	'<option value="'.$ivalue->id.'" rate="'.$ivalue->price.'">'.$ivalue->name.'</option>';
				}
			}
			$html .= '</optgroup>';
		}
		$html .= '</select>';
		$html .= '</div>';
		//ITEM ERROR
		$html .= '<span class="item-error help-block hide" style="color:#a94442;">at least 1 Item must be selected!</span>';

		$html .= '<div class="form-group form-group-qty hide qty-form-'.$count_form.'">';
		$html .= '<label class="control-label" for="quantity">QUANTITY</label>';
		$html .= '<div class="input-group">
		<span class="input-group-addon minus-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-minus" > </i></span>
		<input type="text" class="form-control qty" disabled="disabled" id="qty-'.$count_form.'" aria-label="Amount (to the nearest dollar)"  name="qty-'.$count_form.'" placeholder="0">
		<span class="input-group-addon add-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-plus" > </i></span>
		</div>';
		$html .= '</div>';
		//QTY ERROR
		$html .= '<span class="qty-error help-block hide" style="color:#a94442;">Please add an item</span>';
		


		$html .= '												
		<div class="form-group form-group-di form-inline hide di-form-'.$count_form.'" >
		<div class="col-sm-2" style="padding-left:0;">
		<label class="control-label" >Height</label>
		</div>
		<div class="input-group form-group-height col-sm-4 col-xs-12 pull-left">
		<input type="text" class="form-control height" disabled="disabled" id="height-'.$count_form.'" name="height-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
		<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-vertical"></i></span>
		</div>
		<div class=" col-sm-2">
		<label class="control-label">Length</label>
		</div>
		<div class="input-group form-group-length col-sm-4 col-xs-12 pull-left">
		<input type="text" disabled="disabled" class="form-control length" id="length-'.$count_form.'" name="length-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
		<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-horizontal"></i></span>
		</div>

		</div>';

		$html .= '<span class="di-error help-block hide" style="color:#a94442;">height and lenght are required</span>';

		$html .= '<div class="form-group form-group-rate hide rate-form-'.$count_form.'">';
		$html .= '<label class="control-label" for="rate">RATE</label>';
		$html .= '<input id="rate-'.$count_form.'" type="text" name="rate-'.$count_form.'" class="form-control content-rate" disabled="disabled" placeholder="$00.0">';
		$html .= '</div>';

		$html .= '<div class="form-group form-group-price hide price-form-'.$count_form.'">';
		$html .= '<label class="control-label" for="price">PRICE</label>';
		$html .= '<input type="text" name="total-'.$count_form.'" class="form-control content-price" id="total-'.$count_form.'" disabled="disabled" placeholder="$00.0">';
		$html .= '</div>';

		$html .= '</div>';
		$html .= '</div>';
		$html .= '';
		$html .= '<div class="panel-footer clearfix">';
		$html .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
		$html .= '</div>';

		$html .= '</div>';
		return $html;
	}

	//PREPARE ORDERS FROM SESSION
	public static function prepareOrderFromSession($preview_data){
		$services = Service::all();
		$inventories = Inventory::all();
		$inventory_items = InventoryItem::all();
		$html = '';
		$count_form = 0;
		$parents = 0;
		if (isset($preview_data)) {

			//ORDER(SERVICES)
			if (isset($preview_data['service_order'])) {
				foreach ($preview_data['service_order'] as $pd_key => $pd_value) {
					$html .= '<div class="panel panel-success content-set" this_set="'.$count_form.'" style="margin-top:10px;">';

					$html .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
					$html .= 'data-parent="#accordion" href="#accordion-'.$count_form.'" aria-expanded="true" aria-controls="collapseOne"';
					$html .= 'style="cursor: pointer;">';
					$html .= '<h4 class="panel-title">';
					$html .= '<a class="this-title">';
					$html .= 'Order '.($count_form+1);
					$html .= '</a>';
					$html .= '<a>';
					$html .= '<i class="glyphicon glyphicon-chevron-down pull-right"></i>';
					$html .= '</a>';
					$html .= '</h4>';
					$html .= '</div>';
					
					$html .= '<div id="accordion-'.$count_form.'" this_set="'.$count_form.'" class="panel-collapse collapse in collapse-'.$count_form.'" role="tabpanel" aria-labelledby="headingOne">';
					$html .= '<div class="panel-body panel-input">';

					$html .= '	<div class="form-group">
					<div class="radio">
					<label>
					<input type="radio" class="radio-option " checked name="content_radio_'.$count_form.'" id="service-radio" value="1">
					Services
					</label>
					</div>
					<div class="radio " >
					<label>
					<input type="radio" class="radio-option" name="content_radio_'.$count_form.'" id="item-radio" value="2">
					Items
					</label>
					</div>
					</div>';

					//RADIO ERROR
					$html .= '<span class="radio-error help-block hide" style="color:#a94442;">Please complete the order</span>';
				
					$html .= '<div class="form-group form-group-make  make-form-'.$count_form.' ">';
					$html .= '<label class="control-label" for="make">MAKE</label>';
					$html .= '<select class="form-control select-make" status=""  name="select-make-'.$count_form.'" id="select-make-'.$count_form.'">';
					$html .= '<option rate="'.$pd_value['rate'].'" value="'.$pd_value['id'].'">'.$pd_value['name'].'</option>';
					foreach ($services as $service_key => $service_value) {
						//ADD THE ITEMS EXCEPT FOR THE ONE THAT IS CHOSEN
						if ($pd_value['id'] != $service_value->id) {
							$html .=	'<option value="'.$service_value->id.'" rate="'.$service_value->rate.'">'.$service_value->name.'</option>';
						}
					}
					$html .= '</select>';
					$html .= '</div>';
					//MAKE ERROR
					$html .= '<span class="make-error help-block hide" style="color:#a94442;">Service must be selected!</span>';

					$html .= '<div class="form-group form-group-item  item-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="item">ITEM</label>';
					$html .= '<select class="form-control select-item" status="" name="select-item-'.$count_form.'" id="select-item-'.$count_form.'">';
					$html .= '<option  value="'.$pd_value['item_id'].'">'.$pd_value['item_name'].' </option>';
					foreach ($inventories as $key => $value) {
						$html .= '<optgroup label='.$value->name.'>';
						foreach ($inventory_items as $ikey => $ivalue) {
							if ($ivalue->inventory_id == $value->id) {
								if ($pd_value['item_id'] != $ivalue->id) {
								$html .=	'<option value="'.$ivalue->id.'" rate="'.$ivalue->price.'">'.$ivalue->name.'</option>';
								}
							}
						}
						$html .= '</optgroup>';
					}
					$html .= '</select>';
					$html .= '</div>';
					//ITEM ERROR
					$html .= '<span class="item-error help-block hide" style="color:#a94442;">at least 1 Item must be selected!</span>';

					$html .= '<div class="form-group form-group-qty hide qty-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="quantity">QUANTITY</label>';
					$html .= '<div class="input-group">
					<span class="input-group-addon minus-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-minus" > </i></span>
					<input type="text" class="form-control qty" disabled="disabled" id="qty-'.$count_form.'" aria-label="Amount (to the nearest dollar)"  name="qty-'.$count_form.'" placeholder="0">
					<span class="input-group-addon add-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-plus" > </i></span>
					</div>';
					$html .= '</div>';
					//QTY ERROR
					$html .= '<span class="qty-error help-block hide" style="color:#a94442;">Please add an item</span>';

					$html .= '												
					<div class="form-group form-group-di form-inline di-form-'.$count_form.'" >
					<div class="col-sm-2" style="padding-left:0;">
					<label class="control-label" >Height</label>
					</div>
					<div class="input-group form-group-height col-sm-4 col-xs-12 pull-left">
					<input type="text" class="form-control height" value="'.$pd_value['height'].'" id="height-'.$count_form.'" name="height-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-vertical"></i></span>
					</div>
					<div class=" col-sm-2">
					<label class="control-label">Length</label>
					</div>
					<div class="input-group form-group-length col-sm-4 col-xs-12 pull-left">
					<input type="text" value="'.$pd_value['length'].'" class="form-control length" id="length-'.$count_form.'" name="length-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-horizontal"></i></span>
					</div>

					</div>';
				
					$html .= '<span class="di-error help-block hide" style="color:#a94442;">height and lenght are required</span>';

					$html .= '<div class="form-group form-group-rate rate-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="rate">RATE</label>';
					$html .= '<input id="rate-'.$count_form.'" value="$'.$pd_value['rate'].'" rate="'.$pd_value['rate'].'" type="text" name="rate-'.$count_form.'" class="form-control content-rate" disabled="disabled" placeholder="$00.0 ">';
					$html .= '</div>';

					$html .= '<div class="form-group form-group-price price-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="price">PRICE</label>';
					$html .= '<input type="text" value="$'.$pd_value['total'].'" name="total-'.$count_form.'" class="form-control content-price" id="total-'.$count_form.'" disabled="disabled" placeholder="$00.0">';
					$html .= '</div>';

					$html .= '</div>';
					$html .= '</div>';
					$html .= '';

					//ADD THE ORDERS HIDDEN FORM
					$html .=	'<input type="hidden" class="service-group-' . $parents . ' service-group service-by-count-' . $count_form . '" value="' . $pd_value['id'] . '" name="service_order[' . $parents . '][id]" id="service-' . $count_form . '" >
        						<input type="hidden" class="service-group-' . $parents . ' service-group service-by-count-' . $count_form . '" value="' . $pd_value['item_id'] . '" name="service_order[' . $parents . '][item_id]" id="service-' . $count_form . '" >
         						<input type="hidden" class="service-group-' . $parents . ' service-group service-by-count-' . $count_form . '" value="' . $pd_value['height'] . '" name="service_order[' . $parents . '][height]" id="service-' . $count_form . '" >
         						<input type="hidden" class="service-group-' . $parents . ' service-group service-by-count-' . $count_form . '" value="' . $pd_value['length'] . '" name="service_order[' . $parents . '][length]" id="service-' . $count_form . '" >';
         			//END OF FORMS

					$html .= '<div class="panel-footer clearfix">';
					$html .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
					$html .= '</div>';
					$html .= '</div>';

					//INCREMENT PARENT BY ONE
					$parents = $parents + 1;
					$count_form = $count_form + 1;
				}
				
			}//END OF SERVICES

			//ORDER(ITEMS)
			if (isset($preview_data['item_order'])) {
				foreach ($preview_data['item_order'] as $pd_i_key => $pd_i_value) {
					$html .= '<div class="panel panel-success content-set" this_set="'.$count_form.'" style="margin-top:10px;">';

					$html .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
					$html .= 'data-parent="#accordion" href="#accordion-'.$count_form.'" aria-expanded="true" aria-controls="collapseOne"';
					$html .= 'style="cursor: pointer;">';
					$html .= '<h4 class="panel-title">';
					$html .= '<a class="this-title">';
					$html .= 'Order '.($count_form+1);
					$html .= '</a>';
					$html .= '<a>';
					$html .= '<i class="glyphicon glyphicon-chevron-down pull-right"></i>';
					$html .= '</a>';
					$html .= '</h4>';
					$html .= '</div>';
					
					$html .= '<div id="accordion-'.$count_form.'" this_set="'.$count_form.'" class="panel-collapse collapse in collapse-'.$count_form.'" role="tabpanel" aria-labelledby="headingOne">';
					$html .= '<div class="panel-body panel-input">';

					$html .= '	<div class="form-group">
					<div class="radio">
					<label>
					<input type="radio" class="radio-option "  name="content_radio_'.$count_form.'" id="service-radio" value="1">
					Services
					</label>
					</div>
					<div class="radio " >
					<label>
					<input type="radio" class="radio-option" checked name="content_radio_'.$count_form.'" id="item-radio" value="2">
					Items
					</label>
					</div>
					</div>';

					//RADIO ERROR
					$html .= '<span class="radio-error help-block hide" style="color:#a94442;">Please complete the order</span>';
				
					$html .= '<div class="hide form-group form-group-make  make-form-'.$count_form.' ">';
					$html .= '<label class="control-label" for="make">MAKE</label>';
					$html .= '<select class="form-control select-make" status=""  name="select-make-'.$count_form.'" id="select-make-'.$count_form.'">';
					foreach ($services as $service_key => $service_value) {
							$html .=	'<option value="'.$service_value->id.'" rate="'.$service_value->rate.'">'.$service_value->name.'</option>';
					}
					$html .= '</select>';
					$html .= '</div>';
					//MAKE ERROR
					$html .= '<span class="make-error help-block hide" style="color:#a94442;">Service must be selected!</span>';

					$html .= '<div class="form-group form-group-item  item-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="item">ITEM</label>';
					$html .= '<select class="form-control select-item" status="" name="select-item-'.$count_form.'" id="select-item-'.$count_form.'">';
					$html .= '<option rate="'.$pd_i_value['price'].'" value="'.$pd_i_value['id'].'">'.$pd_i_value['name'].' </option>';
					foreach ($inventories as $key => $value) {
						$html .= '<optgroup label='.$value->name.'>';
						foreach ($inventory_items as $ikey => $ivalue) {
							if ($ivalue->inventory_id == $value->id) {
								if ($pd_i_value['id'] != $ivalue->id) {
								$html .=	'<option value="'.$ivalue->id.'" rate="'.$ivalue->price.'">'.$ivalue->name.'</option>';
								}
							}
						}
						$html .= '</optgroup>';
					}
					$html .= '</select>';
					$html .= '</div>';
					//ITEM ERROR
					$html .= '<span class="item-error help-block hide" style="color:#a94442;">at least 1 Item must be selected!</span>';

					$html .= '<div class="form-group form-group-qty qty-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="quantity">QUANTITY</label>';
					$html .= '<div class="input-group">
					<span class="input-group-addon minus-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-minus" > </i></span>
					<input type="text" class="form-control qty" value="'.$pd_i_value['qty'].'" id="qty-'.$count_form.'" aria-label="Amount (to the nearest dollar)"  name="qty-'.$count_form.'" placeholder="0">
					<span class="input-group-addon add-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-plus" > </i></span>
					</div>';
					$html .= '</div>';
					//QTY ERROR
					$html .= '<span class="qty-error help-block hide" style="color:#a94442;">Please add an item</span>';
					$html .= '												
					<div class="form-group hide form-group-di form-inline di-form-'.$count_form.'" >
					<div class="col-sm-2" style="padding-left:0;">
					<label class="control-label" >Height</label>
					</div>
					<div class="input-group form-group-height col-sm-4 col-xs-12 pull-left">
					<input type="text" class="form-control height"  id="height-'.$count_form.'" name="height-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-vertical"></i></span>
					</div>
					<div class=" col-sm-2">
					<label class="control-label">Length</label>
					</div>
					<div class="input-group form-group-length col-sm-4 col-xs-12 pull-left">
					<input type="text"  class="form-control length" id="length-'.$count_form.'" name="length-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-horizontal"></i></span>
					</div>
					</div>';
				
					$html .= '<span class="di-error help-block hide" style="color:#a94442;">height and lenght are required</span>';
					$html .= '<div class="form-group hide form-group-rate rate-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="rate">RATE</label>';
					$html .= '<input id="rate-'.$count_form.'"   type="text" name="rate-'.$count_form.'" class="form-control content-rate" disabled="disabled" placeholder="$00.0">';
					$html .= '</div>';

					$html .= '<div class="form-group form-group-price price-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="price">PRICE</label>';
					$html .= '<input type="text" value="$'.$pd_i_value['total'].'" name="total-'.$count_form.'" class="form-control content-price" id="total-'.$count_form.'" disabled="disabled" placeholder="$00.0">';
					$html .= '</div>';

					$html .= '</div>';
					$html .= '</div>';
					$html .= '';
					
					//ADD THE ORDERS HIDDEN FORM
					for ($i_c=0; $i_c < $pd_i_value['qty']; $i_c++) { 
						$html .=	'<input type="hidden" class="item-group-' . $parents . ' item-group item-by-count-' . $i_c . '" value="' . $pd_i_value['id'] . '" name="item_order[' . $parents . '][' . $i_c . ']" id="item-' . $parents . '-' . $i_c . '" >';

					}
         			//END OF FORMS

					$html .= '<div class="panel-footer clearfix">';
					$html .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
					$html .= '</div>';
					$html .= '</div>';
					//INCREMENT PARENT BY ONE
					$parents = $parents + 1;
					$count_form = $count_form + 1;
				}
			}

		}
		return $html;
	}

	public static function prepareDataForEdit($id) {
		//ALL PREPARED DATA GOES IN HERE
		$data = [];
		//EXTRACT DATA FROM SCHEDULES
		$schedules = Schedule::find($id);
		$data['schedule_id'] = $schedules->id;
		$data['invoice_id'] = $schedules->invoice_id;
		//USER INFORMAION
		$data['user_id'] = $schedules->user_id;
		//FOR NOW FIRSTNAME HOLDS BOTH FIRST NAME AND LAST NAME
		$data['first_name'] = $schedules->firstname;
		$data['last_name'] = $schedules->lastname;
		$data['email'] = $schedules->email;
		$data['phone'] = $schedules->phone;
		//ADDRESS
		$data['street'] = $schedules->street;
		$data['unit'] = $schedules->unit;
		$data['city'] = $schedules->city;
		$data['state'] = $schedules->state;
		$data['zipcode'] = $schedules->zipcode;
		$data['new_street'] = "";
		$data['new_unit'] = "";
		$data['new_city'] = "";
		$data['new_state'] = "";
		$data['new_zipcode'] = "";
		$data['is_new'] = null;

		$data['pickup_date'] = date("l, d F, Y",strtotime($schedules->pickup_date));
		$data['delivery_date'] = date("l, d F, Y",strtotime($schedules->delivery_date));

		//OTHER
		$data['estimate_or_order'] = $schedules->type;
		if ($schedules->will_phone == 1) {
			$data['will_phone'] = "checked";
		} else {
			$data['will_phone'] = null;
		}

		//1 = IN-STORE, 2 = IN-HOME
		if (isset($schedules->place)) {
			if ($schedules->place == 1) {
				$data['in_store'] = "checked";
				$data['in_house'] = "";
			} else {
				$data['in_store'] = "";
				$data['in_house'] = "checked";
			}
		}

		if ($schedules->type == 0) {//SET RADIO BUTTON, WORK
			$data['order'] = "checked";
			$data['estimate'] = "";
		} else {//ESTIMATE
			$data['order'] = "";
			$data['estimate'] = "checked";
		}
		//EXTRACT DATA FROM SCHEDULES **END

		//EXTRACT DATA FROM INVOICE
		$invoices = Invoice::find($schedules->invoice_id);
		$data['count_all'] = $invoices->quantity;
		$data['total_befor_tax'] = $invoices->pretax;

		$data['total'] = $invoices->pretax;
		//REDUNDANT 
		$data['subtotal'] = $invoices->pretax;
		$data['total_after_tax'] = $invoices->total;
		$data['tax'] = $invoices->tax;

		//xxx
		//GET STATIC TAX RATE
		$taxes = Tax::find(1);
		$tax_rate = $taxes->rate;
		$data['tax_rate'] = $tax_rate * 100;

		//GET INVOICE ITEMS , ORDERS
		$invoice_items = InvoiceItem::where('invoice_id',$schedules->invoice_id)->get();

		foreach ($invoice_items as $ii_key => $ii_value) {
			if ($ii_value->type == 1) {//SERVICES
				$data['service_order'][$ii_key]['type']= "Services";
				$data['service_order'][$ii_key]['id']= $ii_value->inventory_item_id;
				//GET SERVICES NAME
				$services = Service::find($ii_value->inventory_item_id);
				$data['service_order'][$ii_key]['name']= $services->name;
				$data['service_order'][$ii_key]['description']= $services->description;
				//FIND THE ITEM
				$s_items = InventoryItem::find($ii_value->item_id);
				$data['service_order'][$ii_key]['item_name']= $s_items->name;
				$data['service_order'][$ii_key]['item_id']= $ii_value->item_id;

				$data['service_order'][$ii_key]['rate']= number_format($services->rate, 2);
				//SET HEIGHT AND LENGTH
				$data['service_order'][$ii_key]['height']= $ii_value->height;
				$data['service_order'][$ii_key]['length']= $ii_value->length;
				//TOTAL
				$data['service_order'][$ii_key]['total']= $ii_value->total;

			} else {//ITEMS
				$inventory_items = InventoryItem::find($ii_value->inventory_item_id);
				$data['item_order'][$ii_key]['id']= $inventory_items->id;
				$data['item_order'][$ii_key]['name']= $inventory_items->name;
				$data['item_order'][$ii_key]['price']= $inventory_items->price;
				$data['item_order'][$ii_key]['description']= $inventory_items->description;
				$data['item_order'][$ii_key]['qty']= $ii_value->quantity;
				$data['item_order'][$ii_key]['total']= $ii_value->total;
			}
		}
		return $data;
	}

	public static function prepareAllForPreview($Input_all) {
		//ALL PREPARED DATA GOES IN HERE
		$data = [];
		if(isset($Input_all)) {
			//IF USER, SET USER ID
			if (isset($Input_all['user_id'])) {
				$data['user_id'] = $Input_all['user_id'];
			} else {
				$data['user_id'] = null;
			}

			//EDIT PAGE
			if (isset($Input_all['is_edit'])) {
				$data['is_edit'] = $Input_all['is_edit'];
				$data['schedule_id'] = $Input_all['schedule_id'];
				$data['invoice_id'] = $Input_all['invoice_id'];
			} else {
				$data['is_id'] = false;
				$data['schedule_id'] = null;
				$data['invoice_id'] = null;
			}

			//IN-HOUSE OR IN-STORE
			if (isset($Input_all['store_or_house'])) {
				if ($Input_all['store_or_house'] == 1) {//IN STORE
					$data['store_or_house'] = $Input_all['store_or_house'];
					$data['in_store'] = "checked";
					$data['in_house'] = "";
				} else {//IN HOUSE
					$data['store_or_house'] = $Input_all['store_or_house'];
					$data['in_house'] = "checked";
					$data['in_store'] = "";
				}
			} 

			// CHECK IF THE ADDRESS WAS NEW
			if ( 	$Input_all['new_street'] &&
				$Input_all['new_unit'] &&
				$Input_all['new_city'] &&
				$Input_all['new_state'] &&
				$Input_all['new_zipcode']
				) { //NEW ADDRESS WAS SET
				$data['is_new'] = true;
				$data['new_street'] = Input::get('new_street') ;
				$data['new_unit'] = Input::get('new_unit') ;
				$data['new_city'] = Input::get('new_city') ;
				$data['new_state'] = Input::get('new_state') ;
				$data['new_zipcode'] = Input::get('new_zipcode') ;

				$data['street'] = "";
				$data['unit'] = "";
				$data['city'] = "";
				$data['state'] = "";
				$data['zipcode'] = "";

			} else { //OLD ADDRESS
				$data['is_new'] = false;
				$data['street'] = Input::get('street') ;
				$data['unit'] = Input::get('unit') ;
				$data['city'] = Input::get('city') ;
				$data['state'] = Input::get('state') ;
				$data['zipcode'] = Input::get('zipcode') ;

				$data['new_street'] = "";
				$data['new_unit'] = "";
				$data['new_city'] = "";
				$data['new_state'] = "";
				$data['new_zipcode'] = "";
			} 

			if (Input::get('pickup_date') && Input::get('delivery_date')) {
				$data['pickup_date'] = Input::get('pickup_date');
				$data['delivery_date'] = Input::get('delivery_date');
			}

			//IS IT ORDER OR ESTIMATE, ESTIMATE=1, ORDER=2
			if (Input::get('estimate_or_order')) {

				if (Input::get('estimate_or_order') == 1) {
					$data['estimate_or_order'] = 1;
					$data['estimate'] = "checked";
					$data['order'] = "";
				} else {
					$data['estimate_or_order'] = 0;
					$data['order'] = "checked";
					$data['estimate'] = "";
				}
			}

			//WHERE WILL PHONE CHECKED OR NOT 
			if (Input::get('will_phone')) {
				$data['will_phone'] = "checked";
			} else {
				$data['will_phone'] = "";
			}

			//GET AND SET USER INFORMATION
			$data['first_name']= Input::get('first_name');
			$data['last_name']= Input::get('last_name');
			$data['email']= Input::get('email');
			$data['phone']= Input::get('telephone');
			
			//COUNTING ALL ORDERS
			$data['count_all'] = 0;
			//PREPARES ORDERS
			if (Input::get('service_order') || Input::get('item_order')) {
				$data['subtotal'] = 0;
				//PREPARE SERVICE ORDERS
				if (Input::get('service_order')) {
					$service_orders = Input::get('service_order');
					foreach ($service_orders as $key => $s_o) {
						$data['count_all'] = $data['count_all'] + 1;

						$services = Service::find($s_o['id']);
						$data['service_order'][$key]['type']= "Services";
						$data['service_order'][$key]['id']= $services->id;
						$data['service_order'][$key]['name']= $services->name;
						$data['service_order'][$key]['description']= $services->description;
						//FIND THE ITEM
						$items = InventoryItem::find($s_o['item_id']);
						$data['service_order'][$key]['item_name']= $items->name;
						$data['service_order'][$key]['item_id']= $items->id;

						//SET TWO DECIMAL PLACES
						$data['service_order'][$key]['rate']= number_format($services->rate, 2);
						$data['service_order'][$key]['height']= $s_o['height'];
						$data['service_order'][$key]['length']= $s_o['length'];

						// ONLY FOR SESSION
						$total_var = $s_o['length'] * $s_o['height'] * $services->rate;
						$data['service_order'][$key]['total']= number_format($total_var, 2);

						//CALCULATE SUBTOTAL
						$data['subtotal'] = $data['subtotal'] + $total_var;
					}
				}
				//PREPARE ITEM ORDERS
				if (Input::get('item_order')) {
					$item_orders = Input::get('item_order');
					foreach ($item_orders as $ikey => $i_o) {
						$data['count_all'] = $data['count_all'] + 1;
						//GET ITEM ID
						$items = InventoryItem::find($i_o[0]);
						$data['item_order'][$ikey]['id']= $items->id;
						$data['item_order'][$ikey]['name']= $items->name;
						$data['item_order'][$ikey]['price']= $items->price;
						$data['item_order'][$ikey]['description']= $items->description;
						$data['item_order'][$ikey]['qty']= count($i_o);
						//CALCULATE THE TOTAL 
						$total = count($i_o) * $items->price;
						//SET TWO DECIMAL PLACES
						$data['item_order'][$ikey]['total'] = number_format($total, 2) ;
						$data['subtotal'] = $data['subtotal'] + $total;
					}
				}
				//IN-HOUSE = NO TAX, IN-STORE = TAX APPLIES
					if ($Input_all['store_or_house'] == 1) {//IN STORE
						//SET TAX PRICE, SEATTLE 9.5%
						$taxes = Tax::find(1);
						$tax_rate = $taxes->rate;
						$data['tax_rate'] = $tax_rate * 100;
						//TAX FOR SALE
						$taxed = $tax_rate * $data['subtotal'];
						$data['tax'] = number_format($taxed, 2);
						//GET TOTAL AFTER TAX
						$total_after_tax = $data['tax'] + $data['subtotal'];
						//REDUNDANT
						$data['total_befor_tax'] = $data['subtotal'];
						
						$data['total_after_tax'] = number_format($total_after_tax, 2);
					} else {//IN HOUSE
						//SET TAX PRICE, SEATTLE 9.5%
						$tax_rate = 0;
						$data['tax_rate'] = 0;
						//TAX FOR SALE
						$taxed = 0;
						$data['tax'] = number_format($taxed, 2);
						//GET TOTAL AFTER TAX
						$total_after_tax = $data['tax'] + $data['subtotal'];
						//REDUNDANT
						$data['total_befor_tax'] = $data['subtotal'];
						
						$data['total_after_tax'] = number_format($total_after_tax, 2);
					}

			}//END OF ORDERS
		}
		$data['subtotal'] = number_format($data['subtotal'], 2);
		return $data;
	}

}

