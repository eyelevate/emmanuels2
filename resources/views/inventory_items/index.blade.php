@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('js/inventory_items_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Inventory-Items</h1>
	<ol class="breadcrumb">
		<li class="active">Inventory-Items Overview</li>
		<li><a href="{{ action('InventoryItemsController@getAdd') }}">Add an Inventory Item</a></li>
	</ol>
</div>
<div class="table-responsive">
	<table id="inventory_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>item name</th>
				<th>Inventory Group</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="inventory_table_body">
			@foreach($inventories as $inventory)
			<tr>
				<td>{{ $inventory->id }}</td>
				<td>{{ $inventory->name }}</td>
				<td>{{ $inventory->inventory_name }}</td>
				<td>{{ $inventory->status_html }}</td>
				<td><a href="{{ action('InventoryItemsController@getEdit',$inventory->id) }}">Edit</a>/
					{{ Form::open(array('action' => 'InventoryItemsController@postDelete', 'class'=>'remove-form','id'=>'form-'.$inventory->id,'role'=>"form",'files'=> true)) }}
					{{ Form::hidden('inventory_id', $inventory->id) }}
					<a class="remove"  data-toggle="modal" data-target="#myModal" inventory-id="{{$inventory->id}}" count="{{$inventory->item_count}}">Remove</a></td>
					{{ Form::close() }}</td>
				</tr>

				@endforeach
			</tbody>
		</table>

	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header alert alert-warning">
					Warning!
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger remove-btn">Remove</button>
				</div>
			</div>
		</div>
	</div>
	@stop