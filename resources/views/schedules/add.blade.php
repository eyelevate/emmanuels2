@extends($layout)
@section('stylesheets')
@stop
@section('scripts')
<!-- DATEPICKER -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
{!! Html::script('/assets/js/schedules_add.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Schedules Add
			<sup>
				<i type="button" class="glyphicon glyphicon-info-sign"
				data-toggle="tooltip" data-placement="right"
				title="Set Schedule title and description for for future reference e.g. (holiday's schedule)" style="margin:10px;font-size:18px;">
				</i>
			</sup>
	</h1>
	<ol class="breadcrumb">
		<li class="active">Schedules Add 		

	</li>
		<li><a href="{!! action('SchedulesController@getIndex') !!}">Schedules Overview</a></li>
	</ol>
</div>
{!! Form::open(array('action' => 'SchedulesController@postAdd', 'class'=>'','role'=>"form")) !!}
	<div class="panel panel-default">



	  <div class="panel-body">

    	<div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
			<label class="control-label" for="title">Title</label>
			{!! Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Title')) !!}
			@foreach($errors->get('title') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
    	<div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
			<label class="control-label" for="description">Description</label>
			{!! Form::text('description', null, array('class'=>'form-control', 'placeholder'=>'Description')) !!}
			@foreach($errors->get('description') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>


	  </div>
	  <div class="panel-footer clearfix">
	  	<button class="btn btn-primary pull-right">Add</button>
	  </div>
	</div>
{!! Form::close() !!}

@stop