@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('js/services_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Services</h1>
	<ol class="breadcrumb">
		<li class="active">Services Overview</li>
		<li><a href="{{ action('ServicesController@getAdd') }}">Add an Service</a></li>
	</ol>
</div>
<div class="table-responsive">
	<table id="service_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Company name</th>
				<th>Service Group</th>
				<th>Description</th>
				<th>Service Items</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="service_table_body">
			@foreach($services as $service)
			<tr>
				<td>{{ $service->id }}</td>
				<td>{{ $service->company_name }}</td>
				<td>{{ $service->name }}</td>
				<td>{{ $service->description }}</td>
				<td>{{ $service->item_count }}</td>
				<td>{{ $service->status_html }}</td>
				<td><a href="{{ action('ServicesController@getEdit',$service->id) }}">Edit</a>/
					{{ Form::open(array('action' => 'ServicesController@postDelete', 'class'=>'remove-form','id'=>'form-'.$service->id,'role'=>"form",'files'=> true)) }}
					{{ Form::hidden('service_id', $service->id) }}
					<a class="remove"  data-toggle="modal" data-target="#myModal" service-id="{{$service->id}}" count="{{$service->item_count}}">Remove</a></td>
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