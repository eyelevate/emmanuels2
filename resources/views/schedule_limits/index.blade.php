@section('stylesheets')
@stop
@section('scripts')
<!-- DATEPICKER -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
{{ HTML::script('js/schedule_limits_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Schedule Setup</h1>
	<ol class="breadcrumb">
		<li class="active">Schedule Setup</li>
		<li><a href="{{ action('ScheduleRulesController@getIndex') }}">Schedule-rules Overview</a></li>
	</ol>
</div>
<div class="row" id="this-body" style="min-height:500px;"> 
	{{ Form::open(array('action' => 'ScheduleLimitsController@postIndex', 'class'=>'','id'=>'add-form','role'=>"form")) }}
	<div class="col-md-3" style="margin-bottom:5px;">
		<ul id="deliveryStepy" class="nav nav-pills nav-stacked">
			<li id="schedule-stepy" class="active" role="presentation"><a href="#type"><span class="badge">1</span> Schedules</a></li>
			<li id="overwrite-stepy" class="" role="presentation"><a href="#overwrite"><span class="badge">2</span> Overwrite Dates </a></li>
			<li id="blackout-stepy" class="" role="presentation"><a href="#blackout_date"><span class="badge">3</span> Blackout Dates</a></li>
		</ul>
	</div>
	<div class="col-md-9 pull-right">
		<!-- TYPE STEP -->
		<div id="type" class="steps panel panel-success " >
			<div class="panel-heading" style="font-size:17px;"><strong>Default Schedules</strong></div>
			<div class="panel-body">
				<!-- FIRST SECTION -->
				<div class="first_section" id="step_1_wrapper">
					{{ View::make('partials.companies.delivery_hours') }}
				</div>
				<!-- FIRST SECTION **END-->
			</div>
			<div class="panel-footer clearfix">
				<button type="button" id="first-next" step="1" class="btn btn-primary pull-right next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
			
		</div>

		<?php
		$overwrite_hours = array();
		$overwrite_minutes = array();
		$overwrite_ampm = array('am'=>'am','pm'=>'pm');
		for ($i=0; $i < 13; $i++) { 
			if ($i == 0) {
				$overwrite_hours[$i] = 'Select hour';
			} else if($i < 10){
				$overwrite_hours['0'.$i] = $i;
			} else {
				$overwrite_hours[$i] = $i;
			}
		}
		for ($i=0; $i <= 60; $i++) {
			if($i == 0) {
				$overwrite_minutes[""] = 'Select minute';
			} else if($i < 11){
				$new_i = $i - 1;
				$overwrite_minutes['0'.$new_i] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
			} else {
				$overwrite_minutes[$i-1] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
			}
		}

		?>	

		<!-- OVERWRITE STEP -->
		<div id="overwrite" class="steps panel panel-success hide ">
			<div class="panel-heading clearfix" style="font-size:17px;"><strong>Overwrite Date</strong>			
				<a id="add-overwrite" class="btn btn-primary pull-right">Add Another Overwrite Date &nbsp <i class="glyphicon glyphicon-plus "></i> </a>
			</div>
			
			<div id="content-wrapper">
				<div class="panel panel-default content-set this-wrapper" this-set="0" style="margin-top:10px;border:none;border-radius:0;  border-bottom: 1px solid rgb(174, 174, 174);
				border-top: 1px solid rgb(174, 174, 174);">

				<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"
				data-parent="#accordion" href="#accordion-0" aria-expanded="true" aria-controls="collapseOne"
				style="cursor: pointer;border:none;">
				<h4 class="panel-title">
					<a class="this-title">
						OverWrite Date 1 <span style="color:#d9534f" class="hide glyphicon glyphicon-warning-sign this-error-sign this-error-sign-0"></span>
					</a>
					<a>
						<i class="glyphicon glyphicon-chevron-down pull-right"></i>
					</a>
				</h4>
			</div>
			<div id="accordion-0" this-set="0" class="panel-collapse collapse in collapse-0" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body panel-input">
					<!-- PANEL START -->
					<div class="overwrite-container">
						<!-- PANEL START -->
						<div class="panel-body overwrite-wrapper"  style="padding: 6px;">
							<h4 class="first-group-title">Type</h4>
							<hr class="title-hr">
							<div class="form-group">
								<select class="form-control type-select" name="overwrite[0][type]">
									<option value="single">Single</option>
									<option value="range">Range</option>
								</select>
							</div>
							<h4 class="group-title">Date</h4>
							<hr class="title-hr">
							<div class="single-wrapper box">
								<div class="input-group input-group-md">
									<span class="input-group-addon" >Select Date</span>
									<input type="text" name="overwrite[0][date]" id="overwrite-date-single-0" class="form-control overwrite-date-single"  aria-describedby="sizing-addon1">
								</div>
								<div  class="hide single-date-error error" style="color:#a94442">The date field is required</div>
							</div>

							<div class=" hide range-wrapper box">
								<div class="input-group input-group-md">
									<span class="input-group-addon" >Start Date</span>
									<input type="text" name="overwrite[0][start]"  id="overwrite-date-range-start-0" class="form-control overwrite-date-range-start"  aria-describedby="sizing-addon1">
								</div>
								<div  class="hide start-date-error error " style="color:#a94442">The start field is required</div>
								<div class="box">
									<div class="input-group input-group-md" style="margin-top:10px;">
										<span class="input-group-addon" >End Date</span>
										<input type="text" name="overwrite[0][end]"  id="overwrite-date-range-end-0" class="form-control overwrite-date-range-end"  aria-describedby="sizing-addon1">
									</div>
									<div  class="hide end-date-error error" style="color:#a94442">The end field is required</div>
								</div>

							</div>

							<h4 class="group-title">Schedules</h4>
							<hr class="title-hr">

							<!-- TABLE START -->
							<table class="table table-bordered table-condensed overwrite_hours_container" style="border:none" id="">
								<tbody>
									<tr>
										<td class="list-group" style="border:none;">
											<fieldset>
												<div class="list-group-item" style="height:107px;">
													<h4 class="list-group-item-heading">Start</h4>
													<div class="col-xs-4">
														<div class="form-group ">
															{{ Form::select('overwrite[0][open_hour]', $overwrite_hours, '', array('class'=>'form-control form-selects overwrite-select-hour-open','this_category'=>'0','not_empty'=>'true','placeholder'=>'Select Hour')); }}
															<div class="select-error hide" style="color:#a94442">The hour field is required</div>
														</div>
													</div>
													<div class="col-xs-4">
														<div class="form-group ">
															{{ Form::select('overwrite[0][open_minute]', $overwrite_minutes, '', array('class'=>'form-control form-selects overwrite-select-minute-open','this_category'=>'0','not_empty'=>'true','placeholder'=>'Select Minute')); }}
															<div class="select-error hide" style="color:#a94442">The minute field is required</div>
														</div>
													</div>
													<div class="col-xs-4">
														<div class="form-group ">
															{{ Form::select('overwrite[0][open_ampm]', $overwrite_ampm, '', array('class'=>'form-control form-selects overwrite-select-ampm-open','this_category'=>'0','not_empty'=>'true','placeholder'=>'Select Minute')); }}
															<div class="select-error hide" style="color:#a94442">This field is required</div>
														</div>	
													</div>
												</div>
												<div class="list-group-item" style="height:107px;">
													<h4 class="list-group-item-heading">End</h4>
													<div class="col-xs-4">
														<div class="form-group ">
															{{ Form::select('overwrite[0][close_hour]', $overwrite_hours, '', array('class'=>'form-control form-selects overwrite-select-hour-close','this_category'=>'0','not_empty'=>'true','placeholder'=>'Select Hour')); }}
															<div class="select-error hide" style="color:#a94442">The hour field is required</div>
														</div>
													</div>
													<div class="col-xs-4">
														<div class="form-group ">
															{{ Form::select('overwrite[0][close_minute]', $overwrite_minutes, '', array('class'=>'form-control form-selects overwrite-select-minute-close','this_category'=>'0','not_empty'=>'true','placeholder'=>'Select Minute')); }}
															<div class="select-error hide" style="color:#a94442">The minute field is required</div>
														</div>
													</div>
													<div class="col-xs-4">
														<div class="form-group ">
															{{ Form::select('overwrite[0][close_ampm]', $overwrite_ampm, '', array('class'=>'form-control form-selects overwrite-select-ampm-close','this_category'=>'0','not_empty'=>'true','placeholder'=>'Select Minute')); }}
															<div class="select-error hide" style="color:#a94442">This field is required</div>
														</div>
													</div>
													<span id="time-error-overwrite-0" class="time-error-overwrite hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
												</div>
											</fieldset>
										</td>
									</tr>
								</tbody>
							</table>
							<!-- TABLE END -->

							<h4 class="group-title">Limit</h4>
							<hr class="title-hr">

							<div class="input-group input-group-md">
								<span class="input-group-addon" >Number Of Employees</span>
								<input type="text" name="overwrite[0][number_of_employee]" class="form-control employees-no"  aria-describedby="sizing-addon1">
							</div>
							<span class="hide employees-no-error" style="color:#a94442;width:50px;">This field is required</span>
							<span class="hide employees-no-error-numeric" style="color:#a94442;width:50px;">This field must only contain number</span>

						</div>
						<!-- PANEL END -->

					</div>

					<!-- PANEL END -->
				</div>

			</div>
			<div class="panel-footer clearfix">
				<button type="button"  class="btn btn-danger btn-sm pull-right remove-overwrite" >Remove <i class="glyphicon glyphicon-trash"></i></button>
			</div>
		</div>
	</div>


	<div class="panel-footer clearfix">
		<button type="button" class="previous btn btn-default" step="1"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
		<button type="button" id="next-btn" step="2" class="btn btn-primary pull-right next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
	</div>

</div>



<!-- DATE STEP -->
<div id="blackout_date" class="steps panel panel-success hide">
	<div class="panel-heading" style="font-size:17px;"><strong>Blackout Dates</strong></div>
	<div class="panel-body">
		<div class="third_section">
			<div class="blackout wrapper">
				<div class="input-group input-group-md">
					<span class="input-group-addon" >Pick a Date</span>
					<input type="text"  id="blackout-input" class="form-control"  aria-describedby="sizing-addon1">
				</div>

				<div id="blackout-group-wrapper">



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
{{ Form::close() }}
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