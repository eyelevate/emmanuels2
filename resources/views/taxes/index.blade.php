@extends($layout)
@section('stylesheets')
{!! Html::style('/packages/DataTables-Bootstrap3/BS3/assets/css/datatables.css') !!}
@stop
@section('scripts')
{!! Html::script('/assets/js/taxes_index.js') !!}
@stop
@section('content')
	<div class="jumbotron">
		<h1>Taxes</h1>
		<ol class="breadcrumb">
			<li class="active">Taxes Overview</li>
			<li><a href="{!! action('TaxesController@getAdd') !!}">Add Tax</a></li>
		</ol>
	</div>
	<div class="table-responsive">
	<table id="tax_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>City</th>
				<th>State</th>
				<th>Country</th>
				<th>Zipcode</th>
				<th>Rate</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="tax_table_body">
			@foreach($taxes as $tax)
			<tr>
				<td>{!! $tax->id !!}</td>
				<td>{!! $tax->city !!}</td>
				<td>{!! $tax->state !!}</td>
				<td>{!! $tax->country !!}</td>
				<td>{!! $tax->zipcode !!}</td>
				<td>{!! $tax->rate !!}</td>
				<td>{!! $tax->status_Html !!}</td>
				<td><a href="{!! action('TaxesController@getEdit',$tax->id) !!}">Edit</a>/
					{!! Form::open(array('action' => 'TaxesController@postDelete', 'class'=>'remove-form','id'=>'form-'.$tax->id,'role'=>"form",'files'=> true)) !!}
					{!! Form::hidden('tax_id', $tax->id) !!}
					<a class="remove"  data-toggle="modal" data-target="#myModal" tax-id="{!!$tax->id!!}" count="{!!$tax->item_count!!}">Remove</a></td>
					{!! Form::close() !!}</td>
					
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