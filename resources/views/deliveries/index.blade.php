@section('stylesheets')
{{ HTML::style('packages/DataTables-Bootstrap3/BS3/assets/css/datatables.css') }}
@stop
@section('scripts')
{{ HTML::script('js/deliveries_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Deliveries</h1>
	<ol class="breadcrumb">
		<li class="active">Deliveries Overview</li>
		<li><a href="{{ action('DeliveriesController@getAdd') }}">Add an Inventory</a></li>
	</ol>
</div>

<div class="table-responsive">
	<table id="delivery_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Company name</th>
				<th>First name</th>
				<th>Last name</th>
				<th>Phone</th>
				<th>City</th>
				<th>Street</th>
				<th>State</th>
				<th>Country</th>
				<th>Zipcode</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="delivery_table_body">
			@foreach($deliveries as $delivery)
			<tr> 
				<td>{{ $delivery->id }}</td>
				<td>{{ $delivery->company_name }}</td>
				<td>{{ $delivery->firstname }}</td>
				<td>{{ $delivery->lastname }}</td>
				<td>{{ $delivery->phone }}</td>
				<td>{{ $delivery->city }}</td>
				<td>{{ $delivery->street }}</td>
				<td>{{ $delivery->state }}</td>
				<td>{{ $delivery->country }}</td>
				<td>{{ $delivery->zipcode }}</td>
				<td>{{ $delivery->status_html }}</td>
				<td><a href="{{ action('DeliveriesController@getEdit',$delivery->id) }}">Edit</a>/
					{{ Form::open(array('action' => 'DeliveriesController@postDelete', 'class'=>'remove-form','id'=>'form-'.$delivery->id,'role'=>"form",'files'=> true)) }}
					{{ Form::hidden('delivery_id', $delivery->id) }}
					<a class="remove"  data-toggle="modal" data-target="#myModal" delivery-id="{{$delivery->id}}" >Remove</a></td>
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