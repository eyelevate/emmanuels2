@extends($layout)
@section('stylesheets')
  {!! Html::style('/assets/css/schedule_rules/add.css') !!}
@stop
@section('scripts')
<!-- DATEPICKER -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
{!! Html::script('/assets/js/schedule_rules_add.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Schedule Setup</h1>
	<ol class="breadcrumb">
		<li class="active">Schedule Setup</li>
		<li><a href="{!! action('ScheduleRulesController@getIndex') !!}">Schedule-rules Overview</a></li>
	</ol>
</div>
<?php
$overwrite_hours = array();
$overwrite_minutes = array();
$overwrite_ampm = array('am'=>'am','pm'=>'pm');
for ($i=0; $i < 13; $i++) { 
	if ($i == 0) {
	} else if($i < 10){
		$overwrite_hours['0'.$i] = $i;
	} else {
		$overwrite_hours[$i] = $i;
	}
}
for ($i=0; $i <= 60; $i++) {
	if($i == 0) {
	} else if($i < 11){
		$new_i = $i - 1;
		$overwrite_minutes['0'.$new_i] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
	} else {
		$overwrite_minutes[$i-1] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
	}
}
?>	
<div class="row" id="this-body" style="min-height:500px;"> 
	{!! Form::open(array('action' => 'ScheduleRulesController@postAdd', 'class'=>'','id'=>'add-form','role'=>"form")) !!}
	<div class="col-md-3" style="margin-bottom:5px;">
		<ul id="deliveryStepy" class="nav nav-pills nav-stacked">
			<li id="s-stepy" class="active" role="presentation"><a href="#setup"><span class="badge">1</span> Schedules</a></li>
			<li id="schedule-stepy" class="" role="presentation"><a href="#type"><span class="badge">2</span> Weekly Schedule</a></li>
			<li id="blackout-stepy" class="" role="presentation"><a href="#blackout_date"><span class="badge">3</span> Blackout Dates and Areas</a></li>
		</ul>
	</div>
	<div class="col-md-9 pull-right">
		<div id="setup" class="steps panel panel-success">
			<div class="panel-heading" style="font-size:17px;"><strong>Schedules</strong></div>
			<div class="panel-body">

				<div class="form-group {{ $errors->has('schedules-select') ? 'has-error' : false }}">
					<label class="control-label" for="schedules-select">Schedules</label>
					{!! Form::select('schedules-select', $schedule_select, null ,array('id'=>'schedules-select','class'=>'form-control')) !!}
					@foreach($errors->get('schedules-select') as $message)
					<span class='help-block'>{{ $message }}</span>
					@endforeach
				</div>	
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

				<label class="control-label" for="drivers">Schedule Time  
						<i type="button" class="glyphicon glyphicon-info-sign" data-toggle="tooltip"
						 data-placement="top" title="The time that it takes to complete a single schedule"></i>

				</label>
				<div class="list-group-item" style="border: none;">
					<div class="col-xs-6 s_g_container">
						<div class="form-group ">
							{!! Form::select('schedule_time[hour]', $overwrite_hours, '', array('class'=>'form-control form-selects overwrite-select-hour-open','this_category'=>'0','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
							<div class="select-error hide" style="color:#a94442">The hour field is required</div>
						</div>
					</div>
					<div class="col-xs-6 s_g_container last_s_g">
						<div class="form-group ">
							{!! Form::select('schedule_time[minute]', $overwrite_minutes, '', array('class'=>'form-control form-selects overwrite-select-minute-open','this_category'=>'0','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
							<div class="select-error hide" style="color:#a94442">The minute field is required</div>
						</div>
					</div>

				</div>

				
			</div>
			<div class="panel-footer clearfix">
				<button type="button" id="first-next" step="1" class="btn btn-primary pull-right next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>

		<div id="type" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>Default Schedules</strong></div>
			<div class="panel-body">

				<!-- FIRST SECTION -->
				<div class="first_section" id="step_1_wrapper">
					{!! View::make('partials.schedules.weekly_schedules') !!}
				</div>
				<!-- FIRST SECTION -->
				
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="button" id="first-next" step="2" class="btn btn-primary pull-right next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>


		<!-- DATE STEP -->
		<div id="blackout_date" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>Blackout Dates and Areas</strong></div>
			<div class="panel-body">
				<div class="third_section">

					
					<div class="blackout wrapper">
						<label class="control-label" for="description">Areas</label>

						<i type="button" class="glyphicon glyphicon-info-sign" data-toggle="tooltip"
						 data-placement="top" title="Blackout dates are dates that services are not available. For example a major holiday."></i>
						
						<div class="input-group">
						  <span class="input-group-addon">Enter a zipcode</span>
						  <input type="text" class="form-control area-text">
						  <span class="input-group-addon add-area">Add</span>
						</div>
						<div class="alert alert-danger hide" id="area-dup" role="alert">Duplicate data</div>
						<div class="panel panel-default">
						  <div class="panel-body" id="area-group-wrapper">
						    
						  </div>
						</div>

					</div>

					<hr>
					<div class="blackout wrapper">
						<label class="control-label" for="description">Blackout Dates</label>

						<i type="button" class="glyphicon glyphicon-info-sign" data-toggle="tooltip"
						 data-placement="top" title="Blackout dates are dates that services are not available. For example a major holiday."></i>

						<div class="input-group input-group-md">
							<span class="input-group-addon" >Pick a Date</span>
							<input type="text"  id="blackout-input" class="form-control"  aria-describedby="sizing-addon1">
						</div>

						<div class="panel panel-default">
						  <div class="panel-body" id="blackout-group-wrapper">
						    
						  </div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="1"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="submit" id="submit-btn" class="btn btn-primary pull-right" >Submit <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>

		</div>
	</div>
	{!! Form::close() !!}
</div>
<style>
.title-hr{
	margin-top: 10px;
	margin-bottom: 10px;
}
.group-title{
	margin-top: 35px;
}
.first-group-title{
	margin-top: 0px;
}
.alert-style{
	margin-top: 10px;
	color: whitesmoke;
	background-color: black;
	border-color: gray;
}
</style>
@stop