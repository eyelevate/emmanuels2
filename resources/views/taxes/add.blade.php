@extends($layout)
@section('stylesheets')
@stop
@section('scripts')
{!! Html::script('/packages/priceformat/price_format.2.0.js') !!}
{!! Html::script('/assets/js/taxes_add.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Taxes Add</h1>
	<ol class="breadcrumb">
		<li class="active">Taxes Add</li>
		<li><a href="{!! action('TaxesController@getIndex') !!}">Taxes Overview</a></li>
	</ol>
</div>
{!! Form::open(array('action' => 'TaxesController@postAdd', 'class'=>'','role'=>"form")) !!}
<div  class="panel panel-success">
	<div class="panel-body">
		<div class="form-group {!! $errors->has('name') ? 'has-error' : false !!}">
			<label class="control-label" for="name">Name</label>
			{!! Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name','id'=>'name')) !!}
			@foreach($errors->get('name') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
		<div class="form-group {!! $errors->has('description') ? 'has-error' : false !!}">
			<label class="control-label" for="description">Description</label>
			{!! Form::textarea('description',null, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Description')) !!}
			@foreach($errors->get('description') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>

		<div class="input-group form-group col-md-6">
			<input type="text" id="rate" class="form-control" placeholder="0.0000" aria-describedby="basic-addon2">
			<span class="input-group-addon percentage" id="basic-addon2"></span>
			@foreach($errors->get('rate') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>

		<div class="form-group page-field {!! $errors->has('status') ? 'has-error' : false !!}">
			<label class="control-label" for="status">Status</label>
			{!! Form::select('status', $tax_status, null, array('class'=>'form-control status','not_empty'=>'true','status'=>false)); !!}
			@foreach($errors->get('status') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" class="btn btn-primary pull-right">Submit</button>
	</div>
</div>
{!!Form::close()!!}
@stop