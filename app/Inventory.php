<?php

class Inventory extends \Eloquent {
	protected $fillable = [];
	use SoftDeletingTrait;

	protected $table = 'inventories';
	public static $rules_edit = array(
		'name'=>'required|min:1'
		);
	public static $rules_add = array(
		'name'=>'required|min:1',
		'description'=>'required|min:1'
		);

	public static function prepareInventory($data) {
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
	public static function organize($groups, $items) {
		$organize = array();
		if(isset($groups)) {
			foreach ($groups as $key => $value) {
				$inventory_id = $groups[$key]['id'];
				$inventory_name = $groups[$key]['name'];
				$organize[$key] = array(
					'id' => $inventory_id,
					'name' => $inventory_name
					);
				if(isset($items)) {
					$idx = -1;
					foreach ($items as $ikey => $ivalue) {
						$inventory_group_id = $ivalue['inventory_id'];
						$inventory_item_id = $ivalue['id'];
						$inventory_item_name = $ivalue['name'];
						$inventory_item_desc = $ivalue['description'];
						$inventory_item_price = $ivalue['price'];
						$inventory_item_thumbnail = $ivalue['thumbnail'];
						$inventory_item_image_address = $ivalue['image_address'];
						$inventory_item_tags = $ivalue['tags'];
						$inventory_item_order_number = $ivalue['order_number'];
						$inventory_item_status = $ivalue['status'];
						$inventory_item_list_order = $ivalue['list_order'];
						if($inventory_group_id == $inventory_id) {
							$idx++;
							$organize[$key]['inventory_items'][$ikey] = array(
								'id' => $inventory_item_id,
								'name'=> $inventory_item_name,
								'description'=>$inventory_item_desc,
								'price'=>$inventory_item_price,
								'thumbnail'=>$inventory_item_thumbnail,
								'image_address'=>$inventory_item_image_address,
								'order_number'=>$inventory_item_order_number,
								'tags'=>$inventory_item_tags,
								'tags_html'=>InventoryItem::setTags($inventory_item_tags),
								'status'=>$inventory_item_status,
								'list_order'=>$inventory_item_list_order
								);
						}
					}
				}
			}
		}

		return $organize;
	}
	//WE MAY NEED TWO OF THIS FUNCTION ONE ADD AND ONE FOR EDIT
	public static function create_html($data,$invoice_id)
	{
		$html = ''; // Start html
		if(isset($data)) {
			$html = '<ul id="inventoryTabs" class="nav nav-tabs">'; // Start Inventory Group Nav
			$mdx = -1;
			foreach ($data as $inventory) {
				$mdx++;
				$inventory_group = $inventory['name'];
				$inventory_group_class = ($mdx == 0) ? 'class="active"' : '';
				$html .= '<li role="presentation" '.$inventory_group_class.'><a href="#inventoryItemDiv-'.$inventory['id'].'">'.$inventory_group.'</a></li>';
			}
			$html .= '</ul>';
			$html .= '<br/>';
			$mdx = -1;
			foreach ($data as $inventory) {
				$mdx++;
				$inventory_group_class = ($mdx > 0) ? 'hide' : '';
				$html .= '<ul id="inventoryItemDiv-'.$inventory['id'].'" class="inventoryListDiv list-group media-list '.$inventory_group_class.'">';		
				$inventory_items = (isset($inventory['inventory_items'])) ? $inventory['inventory_items'] : null;
				if(isset($inventory_items)) {
					foreach ($inventory_items as $mi) {
						$inventory_item_qty = 0;
						if(Session::get('invoice_items')) {
							foreach (Session::get('invoice_items') as $iitems) {
								if($mi['id'] == $iitems['id']) {
									$inventory_item_qty = $iitems['qty'];
									break;
								}
							}
						} else {
							$invoice_itms = InvoiceItem::where('invoice_id',$invoice_id)->get();

							foreach ($invoice_itms as $iitems) {
								
								if($mi['id'] == $iitems['inventory_item_id']) {
									$inventory_item_qty = $iitems['quantity'];
									break;
								}
							}
						}
						$inventory_item_price = Job::formatDollar($mi['price']);
						$inventory_item_title = (isset($mi['order_number'])) ? '<span class="badge">'.$mi['order_number'].'</span> '.$mi['name'].' <strong class="label label-primary">'.$inventory_item_price.'</strong>' : $mi['name'].' <strong class="label label-primary">'.$inventory_item_price.'</strong>';
						// Start Html Content for inventory items
						$html .= '<li id="inventoryItemLi-'.$mi['id'].'" class="list-group-item media">';
						$html .= '<div class="media-left pull-left">';
						$html .= '<a class="thumbnail">';
						$html .= '<img class="media-object" src ="/'.$mi['thumbnail'].'" style="width:100px; height:100px;"/>';
						$html .= '</a>';
						$html .= '</div>';
						$html .= '<div class="media-body">';
						$html .= '<h4 class="media-heading">'.$inventory_item_title.'</h4>';
						$html .= $mi['description'];
						$html .= '</div>';
						$html .= '<div class="formDiv pull-left clearfix">';
						$html .= '<div class="form-group">';
						$html .= '<label class="control-label">Item Quantity</label>';
						$html .= '<div class="input-group">';
						$html .= '<a class="subtractQty input-group-addon"><i class="glyphicon glyphicon-chevron-left"></i></a>';
						$html .= '<input class="invoiceItemQty form-control" type="text" value="'.$inventory_item_qty.'" maxlength="3"/>';
						$html .= '<a class="addQty input-group-addon"><i class="glyphicon glyphicon-chevron-right"></i></a>';
						$html .= '</div>';
						$html .= '<div class="hide">';
						$html .= '<input class="invoiceItemId" value="'.$mi['id'].'"/>';
						$html .= '<input class="invoiceItemName" value="'.$mi['name'].'"/>';
						$html .= '<input class="invoiceItemRate" value="'.$mi['price'].'"/>';
						$html .= '</div>';
						$html .= '</div>';
						$html .= '<div class="form-group">';
						$html .= '<label class="control-label">Total Amount</label>';
						$html .= '<div class="input-group">';
						$html .= '<a class="subtractQty input-group-addon">$</a>';
						$html .= '<input class="invoiceItemTotal form-control" type="text" value="'.sprintf('%.2f',round($inventory_item_qty * $mi['price'],2)).'" readonly="readonly"/>';
										// $html .='<form><input type="hidden" name="delivery["total"]" value="'.sprintf('%.2f',round($inventory_item_qty * $mi['price'],2)).'"></form>';
						$html .= '</div>';
						$html .= '</div>';
						$html .= '</div>';

						$html .= '</li>';
					}
				}
				$html .= '</ul>';
			}
			
		} else {
			$html .= '<div class="alert alert-danger">Company not selected. Please select a company in step 1.</div>';
		}
		return $html;
	}

	public static function create_html_add($data,$invoice_id,$count,$company_id)
	{
		$html = ''; // Start html
		if(isset($data)&&($count > 0)) {
			$html = '<ul id="inventoryTabs" class="nav nav-tabs">'; // Start Inventory Group Nav
			$mdx = -1;
			foreach ($data as $inventory) {
				$mdx++;
				$inventory_group = $inventory['name'];
				$inventory_group_class = ($mdx == 0) ? 'class="active"' : '';
				$html .= '<li role="presentation" '.$inventory_group_class.'><a href="#inventoryItemDiv-'.$inventory['id'].'">'.$inventory_group.'</a></li>';
			}
			$html .= '</ul>';
			$html .= '<br/>';
			$mdx = -1;
			foreach ($data as $inventory) {
				$mdx++;
				$inventory_group_class = ($mdx > 0) ? 'hide' : '';
				$html .= '<ul id="inventoryItemDiv-'.$inventory['id'].'" class="inventoryListDiv list-group media-list '.$inventory_group_class.'">';		
				$inventory_items = (isset($inventory['inventory_items'])) ? $inventory['inventory_items'] : null;
				if(isset($inventory_items)) {
					foreach ($inventory_items as $mi) {
						$inventory_item_qty = 0;
						if(Session::get('invoice_items')) {
							foreach (Session::get('invoice_items') as $iitems) {
								if($mi['id'] == $iitems['id']) {
									$inventory_item_qty = $iitems['qty'];
									break;
								}
							}
						} else {
							$invoice_itms = InvoiceItem::where('invoice_id',$invoice_id)->get();

							foreach ($invoice_itms as $iitems) {
								
								if($mi['id'] == $iitems['inventory_item_id']) {
									$inventory_item_qty = $iitems['quantity'];
									break;
								}
							}
						}
						$inventory_item_price = Job::formatDollar($mi['price']);
						$inventory_item_title = (isset($mi['order_number'])) ? '<span class="badge">'.$mi['order_number'].'</span> '.$mi['name'].' <strong class="label label-primary">'.$inventory_item_price.'</strong>' : $mi['name'].' <strong class="label label-primary">'.$inventory_item_price.'</strong>';
						// Start Html Content for inventory items
						$html .= '<li id="inventoryItemLi-'.$mi['id'].'" class="list-group-item media">';
						$html .= '<div class="media-left pull-left">';
						$html .= '<a class="thumbnail">';
						$html .= '<img class="media-object" src ="/'.$mi['thumbnail'].'" style="width:100px; height:100px;"/>';
						$html .= '</a>';
						$html .= '</div>';
						$html .= '<div class="media-body">';
						$html .= '<h4 class="media-heading">'.$inventory_item_title.'</h4>';
						$html .= $mi['description'];
						$html .= '</div>';
						$html .= '<div class="formDiv pull-left clearfix">';
						$html .= '<div class="form-group">';
						$html .= '<label class="control-label">Item Quantity</label>';
						$html .= '<div class="input-group">';
						$html .= '<a class="subtractQty input-group-addon"><i class="glyphicon glyphicon-chevron-left"></i></a>';
						$html .= '<input class="invoiceItemQty form-control" type="text" value="'.$inventory_item_qty.'" maxlength="3"/>';
						$html .= '<a class="addQty input-group-addon"><i class="glyphicon glyphicon-chevron-right"></i></a>';
						$html .= '</div>';
						$html .= '<div class="hide">';
						$html .= '<input class="invoiceItemId" value="'.$mi['id'].'"/>';
						$html .= '<input class="invoiceItemName" value="'.$mi['name'].'"/>';
						$html .= '<input class="invoiceItemRate" value="'.$mi['price'].'"/>';
						$html .= '</div>';
						$html .= '</div>';
						$html .= '<div class="form-group">';
						$html .= '<label class="control-label">Total Amount</label>';
						$html .= '<div class="input-group">';
						$html .= '<a class="subtractQty input-group-addon">$</a>';
						$html .= '<input class="invoiceItemTotal form-control" type="text" value="'.sprintf('%.2f',round($inventory_item_qty * $mi['price'],2)).'" readonly="readonly"/>';
										// $html .='<form><input type="hidden" name="delivery["total"]" value="'.sprintf('%.2f',round($inventory_item_qty * $mi['price'],2)).'"></form>';
						$html .= '</div>';
						$html .= '</div>';
						$html .= '</div>';

						$html .= '</li>';
					}
				} else {
					$html .= '<div class="alert alert-danger">There is no available inventory-item for this inventory group. click on the link to add your first item. <a href="'.action('InventoryItemsController@getAdd',$inventory['id']).'"><strong><u>Create Inventory</u></strong></a></div>';
				}

				$html .= '</ul>';
			}
			
		} else {
			$html .= '<div class="alert alert-danger">Currently there is no available inventory for this company. Click on the link to create your first inventory. <a href="'.action('InventoriesController@getAdd',$company_id).'"><strong><u>Create Inventory</u></strong></a></div>';
		}
		return $html;
	}

	public static function createInvoiceTbodyWithoutSession($items) {
		$html = '';

		if(isset($items)) {
			foreach ($items as $item) {
				$get_items = InventoryItem::find($item['inventory_item_id']);
				$quantity = $item['quantity'];
				$subtotal = Job::formatDollar(round($quantity * $get_items['price'],2));
				$html .= '<tr>';
				$html .= '<td>'.$get_items['name'].'</td>';
				$html .= '<td>'.$item['quantity'].'</td>';
				$html .= '<td>'.$subtotal.'</td>';
				$html .= '<td>';
				$html .= '<a class="removeInvoiceItem" item_id="'.$get_items['id'].'"><i class="glyphicon glyphicon-remove" style="cursor:pointer;"></i></a>&nbsp&nbsp&nbsp';
				$html .= '<a class="editInvoiceItem" item_id="'.$get_items['id'].'"><i class="glyphicon glyphicon-pencil" style="cursor:pointer;"></i></a>';
				$html .= '</td>';
				$html .= '</tr>';
			}
		}

		return $html;
	}



	public static function createInvoiceTbody($items) {
		$html = '';

		if(isset($items)) {
			foreach ($items as $item) {
				$get_items = InventoryItem::find($item['id']);
				$quantity = $item['qty'];
				$subtotal = Job::formatDollar(round($quantity * $get_items->price,2));
				$html .= '<tr>';
				$html .= '<td>'.$get_items->name.'</td>';
				$html .= '<td>'.$item['qty'].'</td>';
				$html .= '<td>'.$subtotal.'</td>';
				$html .= '<td>';
				$html .= '<a class="removeInvoiceItem" item_id="'.$get_items->id.'"><i class="glyphicon glyphicon-remove" style="cursor:pointer;"></i></a>&nbsp&nbsp&nbsp';
				$html .= '<a href="#inveNtorieselection" li-class="inveNtorieselection"  class="editInvoiceItem" item_id="'.$get_items->id.'"><i class="glyphicon glyphicon-pencil" style="cursor:pointer;"></i></a>';
				$html .= '</td>';
				$html .= '</tr>';
			}
		}

		return $html;
	}

	public static function createInvoiceTfootWithoutSession($company_id, $invoice_items) {
		
		$companies = Company::find($company_id);

		$company_zip = ($companies) ? $companies->zipcode : null;
		$taxes = Tax::where('zipcode',$company_zip)->first();
		$tax_rate = ($taxes) ? $taxes->rate : 1;	


		$subtotal = 0;
		if(isset($invoice_items)) {
			foreach ($invoice_items as $item) {
				$get_items = InventoryItem::find($item['inventory_item_id']);
				$quantity = $item['quantity'];
				$subtotal += round($quantity * $get_items['price'],2);
			}
		}

		$tax = round($subtotal * $tax_rate,2);
		$total = round($subtotal * (1+$tax_rate),2);
		$html = '';
		$html .= '<tr>';
		$html .= '<th colspan="2"></th>';
		$html .= '<th>Subtotal</th>';
		$html .= '<th>'.Job::formatDollar($subtotal).'</th>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th colspan="2"></th>';
		$html .= '<th>Tax</th>';
		$html .= '<th>'.Job::formatDollar($tax).'</th>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th colspan="2"></th>';
		$html .= '<th>Total</th>';
		$html .= '<th>'.Job::formatDollar($total).'</th>';
		$html .= '</tr>';	

		return $html;
	}


	public static function createInvoiceTfoot($company_id, $items) {
		$companies = Company::find($company_id);
		$company_zip = ($companies) ? $companies->zipcode : null;
		$taxes = Tax::where('zipcode',$company_zip)->first();
		$tax_rate = ($taxes) ? $taxes->rate : 1;	
		
		$subtotal = 0;
		if(isset($items)) {
			foreach ($items as $item) {
				$get_items = InventoryItem::find($item['id']);
				$quantity = $item['qty'];
				$subtotal += round($quantity * $get_items->price,2);				
			}
		}

		$tax = round($subtotal * $tax_rate,2);
		$total = round($subtotal * (1+$tax_rate),2);
		$html = '';
		$html .= '<tr>';
		$html .= '<th colspan="2"></th>';
		$html .= '<th>Subtotal</th>';
		$html .= '<th>'.Job::formatDollar($subtotal).'</th>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th colspan="2"></th>';
		$html .= '<th>Tax</th>';
		$html .= '<th>'.Job::formatDollar($tax).'</th>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th colspan="2"></th>';
		$html .= '<th>Total</th>';
		$html .= '<th id="total">'.Job::formatDollar($total).'</th>';
		$html .= '</tr>';	

		return $html;
	}



	public static function createInventoryTbody($name,$data) {
		$html = '';

		if(isset($data)) {
			foreach ($data as $inventory) {
				$inventory_items_count = count(InventoryItem::where('inventory_id',$inventory['id'])->get());
				$html .= '<tr>';
				$html .= '<td>'.$inventory['id'].'</td>';
				$html .= '<td>'.$name.'</td>';
				$html .= '<td>'.$inventory['name'].'</td>';
				$html .= '<td>'.$inventory['description'].'</td>';
				$html .= '<td>'.$inventory_items_count.'</td>';
				$html .= '<td>'.$inventory['status_html'].'</td>';
				$html .= '<td><a href="'.action('InventoriesController@getEdit',$inventory['id']).'">Edit</a>/';
				$html .= '<form action="'.action('InventoriesController@postDelete').'" class="remove-form" id="form-'.$inventory['id'].'" ';
				$html .= '<input type="hidden" name="inventory_id" value="'.$inventory['id'].'">';
				$html .= '<a class="remove"  data-toggle="modal" data-target="#myModal" inventory-id="'.$inventory['id'].'" count="'.$inventory_items_count.'">Remove</a>';
				$html .= '</form></td>';
				$html .= '</tr>';
			}
		}

		return $html;
	}

		public static function setQty($session) {
		$this_ = '';



		return $this_;
	}

}