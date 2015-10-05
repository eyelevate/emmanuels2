@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('js/inventories_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Inventories</h1>
	<ol class="breadcrumb">
		<li class="active">Inventories Overview</li>
		<li><a href="{{ action('InventoriesController@getAdd') }}">Add an Inventory</a></li>
	</ol>
</div>
<div class="table-responsive">
	<table id="inventory_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Company name</th>
				<th>Inventory Group</th>
				<th>Description</th>
				<th>Inventory Items</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="inventory_table_body">
			@foreach($inventories as $inventory)
			<tr>
				<td>{{ $inventory->id }}</td>
				<td>{{ $inventory->company_name }}</td>
				<td>{{ $inventory->name }}</td>
				<td>{{ $inventory->description }}</td>
				<td>{{ $inventory->item_count }}</td>
				<td>{{ $inventory->status_html }}</td>
				<td><a href="{{ action('InventoriesController@getEdit',$inventory->id) }}">Edit</a>/
					{{ Form::open(array('action' => 'InventoriesController@postDelete', 'class'=>'remove-form','id'=>'form-'.$inventory->id,'role'=>"form",'files'=> true)) }}
					{{ Form::hidden('inventory_id', $inventory->id) }}
					<a class="remove"  data-toggle="modal" data-target="#myModal" inventory-id="{{$inventory->id}}" count="{{$inventory->item_count}}">Remove</a></td>
					{{ Form::close() }}</td>
					
				</tr>

				@endforeach
			</tbody>
		</table>
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
	</div>
	
	@stop