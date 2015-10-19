<?php
$hours = array();
$minutes = array();
$ampm = array('am'=>'am','pm'=>'pm');
for ($i=0; $i < 13; $i++) { 
	if ($i == 0) {
	} else if($i < 10){
		$hours['0'.$i] = $i;
	} else {
		$hours[$i] = $i;
	}
}
for ($i=0; $i <= 60; $i++) {
	if($i == 0) {
	} else if($i < 11){
		$new_i = $i - 1;
		$minutes['0'.$new_i] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
	} else {
		$minutes[$i-1] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
	}
}
?>	

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default each-day">
		<div class="panel-heading" role="tab" id="headingSund">
			<h4 class="panel-title clearfix">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSund" aria-expanded="true" aria-controls="collapseSund">
					Sunday <span class="day-error-container day-error-container-1 pull-right hide"><span class="day-error-number day-error-number-1"></span> Errors <i class="glyphicon glyphicon-remove"></i></span>
					<span class="day-success-container day-success-container-1 pull-right hide"> <i class="glyphicon glyphicon-ok"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapseSund" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSund">
			<div class="panel-body daybox">

				<table class="table  table-condensed step-1" style="margin-bottom: 0;">
					<tbody>

						<tr class="">
							<td class="weekly-days-td table-none-bordertop">
								<strong>Sunday</strong>
								<div class="radio">
									<label>
										<input type="radio" name="hours[0][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" 
										@if($weekly_schedule_de[0]->open == 'open')
										checked="true"
										@endif
										>
										Open
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="hours[0][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" 
										@if($weekly_schedule_de[0]->open == 'closed')
										checked="true"
										@endif
										>
										Closed
									</label>
								</div>
							</td>
							<td class="list-group table-none-bordertop">
								<fieldset>
									<div class="list-group table-none-bordertop-item" style="height:85px;">
										<h4 class="list-group table-none-bordertop-item-heading">Start</h4>
										<div class="col-xs-4 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][open_hour]', $hours, $weekly_schedule_de[0]->open_hour, array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
												<div class="select-error hide" style="color:#a94442">The hour field is required</div>
											</div>
										</div>
										<div class="col-xs-4 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][open_minute]', $minutes, $weekly_schedule_de[0]->open_minute, array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
												<div class="select-error hide" style="color:#a94442">The minute field is required</div>
												
											</div>
										</div>
										<div class="col-xs-4 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][open_ampm]', $ampm, $weekly_schedule_de[0]->open_ampm, array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
												<div class="select-error hide" style="color:#a94442">This field is required</div>
											</div>
										</div>

									</div>
									<div class="list-group table-none-bordertop-item" style="height:85px;">
										<h4 class="list-group table-none-bordertop-item-heading">End</h4>
										<div class="col-xs-4 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][close_hour]', $hours, $weekly_schedule_de[0]->close_hour, array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
												<div class="select-error hide" style="color:#a94442">The hour field is required</div>
											</div>
										</div>
										<div class="col-xs-4 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][close_minute]', $minutes, $weekly_schedule_de[0]->close_minute, array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
												<div class="select-error hide" style="color:#a94442">The minute field is required</div>
											</div>					
										</div>

										<div class="col-xs-4 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][close_ampm]', $ampm, $weekly_schedule_de[0]->close_ampm, array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
												<div class="select-error hide" style="color:#a94442">This field is required</div>
											</div>					
										</div>
										<span class="time-error time-error-1 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
									</div>


									<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="0">
										<h4 class="list-group table-none-bordertop-item-heading">Breaks</h4>
										<div class="col-xs-3 w_s_container">
											<label class="control-label" for="drivers" style="line-height: 32px;">From : 
											</label>
										</div>
										<div class="col-xs-3 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][break][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
												<div class="select-error hide" style="color:#a94442">The hour field is required</div>
											</div>
										</div>
										<div class="col-xs-3 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][break][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
												<div class="select-error hide" style="color:#a94442">The minute field is required</div>
											</div>					
										</div>
										<div class="col-xs-3 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
												<div class="select-error hide" style="color:#a94442">This field is required</div>
											</div>					
										</div>
										<div class="col-xs-3 w_s_container">
											<label class="control-label" for="drivers" style="line-height: 32px;">To : 
											</label>
										</div>
										<div class="col-xs-3 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][break][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
												<div class="select-error hide" style="color:#a94442">The hour field is required</div>
											</div>
										</div>
										<div class="col-xs-3 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][break][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
												<div class="select-error hide" style="color:#a94442">The minute field is required</div>
											</div>					
										</div>
										<div class="col-xs-3 w_s_container">
											<div class="form-group  form-group-error-not">
												{!! Form::select('hours[0][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
												<div class="select-error hide" style="color:#a94442">This field is required</div>
											</div>					
										</div>
										<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

										<div class="col-xs-12 w_s_container">
											<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
										</div>
										<div class=" col-xs-12 breaks-div"  style="padding: 0;">
											@if(isset($weekly_schedule_de[0]->breaks_html))
											{!! $weekly_schedule_de[0]->breaks_html !!}
											@endif
										</div>
									</div>

									<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
										<h4 class="list-group table-none-bordertop-item-heading">Available Drivers</h4>
										{!! Form::text('hours[0][drivers]', $weekly_schedule_de[0]->drivers, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
										<div class="select-error hide" style="color:#a94442">This field is required</div>
										@foreach($errors->get('drivers') as $message)
										<span class='help-block'>{{ $message }}</span>
										@endforeach
									</div>




								</fieldset>
							</td>
						</tr>

					</tbody>
				</table>


			</div>
		</div>
	</div>
	<div class="panel panel-default each-day">
		<div class="panel-heading" role="tab" id="headingMond">
			<h4 class="panel-title clearfix">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseMond" aria-expanded="true" aria-controls="collapseMond">
					Monday <span class="day-error-container day-error-container-2 pull-right hide"><span class="day-error-number day-error-number-2"></span> Errors <i class="glyphicon glyphicon-remove"></i></span>
					<span class="day-success-container day-success-container-2 pull-right hide"> <i class="glyphicon glyphicon-ok"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapseMond" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMond">
			<div class="panel-body daybox">

				<table class="table  table-condensed step-1" style="margin-bottom: 0;">
					<tbody>
		<tr class="">
			<td class="weekly-days-td">
				<strong>Monday</strong>
				<div class="radio">
					<label>
						<input type="radio" name="hours[1][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" 
						@if($weekly_schedule_de[1]->open == 'open')
							checked="true"
						@endif
						>
						Open
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="hours[1][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" 
						@if($weekly_schedule_de[1]->open == 'closed')
							checked="true"
						@endif
						>
						Closed
					</label>
				</div>
			</td>
			<td class="list-group table-none-bordertop">
				<fieldset>
					<div class="list-group table-none-bordertop-item" style="height:85px;">
						<h4 class="list-group table-none-bordertop-item-heading">Start</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][open_hour]', $hours, $weekly_schedule_de[1]->open_hour, array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][open_minute]', $minutes, $weekly_schedule_de[1]->open_minute, array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][open_ampm]', $ampm, $weekly_schedule_de[1]->open_ampm, array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group table-none-bordertop-item" style="height:85px;">
						<h4 class="list-group table-none-bordertop-item-heading">End</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_hour]', $hours, $weekly_schedule_de[1]->close_hour, array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_minute]', $minutes, $weekly_schedule_de[1]->open_minute, array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_ampm]', $ampm, $weekly_schedule_de[1]->close_ampm, array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<span class="time-error time-error-2 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
					</div>

					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="1">
						<h4 class="list-group table-none-bordertop-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][break][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][break][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][break][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][break][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">
						  		@if(isset($weekly_schedule_de[1]->breaks_html))
									{!! $weekly_schedule_de[1]->breaks_html !!}
								@endif
						  </div>
					</div>



					<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
						 <h4 class="list-group table-none-bordertop-item-heading">Available Drivers</h4>
						{!! Form::text('hours[1][drivers]', $weekly_schedule_de[1]->drivers, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
				</fieldset>
			</td>
		</tr>

					</tbody>
				</table>


			</div>
		</div>
	</div>
	<div class="panel panel-default each-day">
		<div class="panel-heading" role="tab" id="headingTues">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTues" aria-expanded="false" aria-controls="collapseTues">
					Tuesday	<span class="day-error-container day-error-container-3 pull-right hide"><span class="day-error-number day-error-number-3"></span> Errors <i class="glyphicon glyphicon-remove"></i></span>
					<span class="day-success-container day-success-container-3 pull-right hide"> <i class="glyphicon glyphicon-ok"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapseTues" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTues">
			<div class="panel-body daybox">

				<table class="table  table-condensed step-1" style="margin-bottom: 0;">
					<tbody>
							<tr class="">
			<td class="weekly-days-td">
				<strong>Tuesday</strong>
				<div class="radio">
					<label>
						<input type="radio" name="hours[2][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" 
						@if($weekly_schedule_de[2]->open == 'open')
							checked="true"
						@endif
						>
						Open
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="hours[2][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" 
						@if($weekly_schedule_de[2]->open == 'closed')
							checked="true"
						@endif
						>
						Closed
					</label>
				</div>
			</td>
			<td class="list-group table-none-bordertop">
				<fieldset>
					<div class="list-group table-none-bordertop-item" style="height:85px;">
						<h4 class="list-group table-none-bordertop-item-heading">Start</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][open_hour]', $hours, $weekly_schedule_de[2]->open_hour, array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][open_minute]', $minutes, $weekly_schedule_de[2]->open_minute, array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][open_ampm]', $ampm, $weekly_schedule_de[2]->open_ampm, array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group table-none-bordertop-item" style="height:85px;">
						<h4 class="list-group table-none-bordertop-item-heading">End</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_hour]', $hours, $weekly_schedule_de[2]->close_hour, array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_minute]', $minutes, $weekly_schedule_de[2]->close_minute, array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_ampm]', $ampm, $weekly_schedule_de[2]->close_ampm, array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<span class="time-error time-error-3 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
					</div>


					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="2">
						<h4 class="list-group table-none-bordertop-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][break][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][break][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][break][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][break][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">
						  	@if(isset($weekly_schedule_de[2]->breaks_html))
								{!! $weekly_schedule_de[2]->breaks_html !!}
							@endif
						  </div>
					</div>



					<div class="form-group {{ $errors->has('drivers') ? 'has-error' : false }} row ">
						 <h4 class="list-group table-none-bordertop-item-heading">Available Drivers</h4>
						{!! Form::text('hours[2][drivers]', $weekly_schedule_de[2]->drivers, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

				</fieldset>
			</td>
		</tr>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel panel-default each-day">
		<div class="panel-heading" role="tab" id="headingWedn">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseWedn" aria-expanded="false" aria-controls="collapseWedn">
					Wednesday <span class="day-error-container day-error-container-4 pull-right hide"><span class="day-error-number day-error-number-4"></span> Errors <i class="glyphicon glyphicon-remove"></i></span>
					<span class="day-success-container day-success-container-4 pull-right hide"> <i class="glyphicon glyphicon-ok"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapseWedn" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingWedn">
			<div class="panel-body daybox">
				<table class="table  table-condensed step-1" style="margin-bottom: 0;">
					<tbody>
						
<tr class="">
			<td class="weekly-days-td">
				<strong>Wednesday</strong>
				<div class="radio">
					<label>
						<input type="radio" name="hours[3][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" 
						@if($weekly_schedule_de[3]->open == 'open')
							checked="true"
						@endif
						>
						Open
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="hours[3][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" 
						@if($weekly_schedule_de[3]->open == 'closed')
							checked="true"
						@endif
						>
						Closed
					</label>
				</div>
			</td>
			<td class="list-group table-none-bordertop">
				<fieldset>
					<div class="list-group table-none-bordertop-item" style="height:85px;">
						<h4 class="list-group table-none-bordertop-item-heading">Start</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][open_hour]', $hours, $weekly_schedule_de[3]->open_hour, array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][open_minute]', $minutes, $weekly_schedule_de[3]->open_minute, array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][open_ampm]', $ampm, $weekly_schedule_de[3]->open_ampm, array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group table-none-bordertop-item" style="height:85px;">
						<h4 class="list-group table-none-bordertop-item-heading">End</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_hour]', $hours, $weekly_schedule_de[3]->close_hour, array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_minute]', $minutes, $weekly_schedule_de[3]->close_minute, array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[3][close_ampm]', $ampm, $weekly_schedule_de[3]->close_ampm, array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
							<span class="time-error time-error-4 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>

					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="3">
						<h4 class="list-group table-none-bordertop-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][break][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][break][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][break][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][break][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">
						  	@if(isset($weekly_schedule_de[3]->breaks_html))
								{!! $weekly_schedule_de[3]->breaks_html !!}
							@endif
						  </div>
					</div>

					<div class="form-group {{ $errors->has('drivers') ? 'has-error' : false }} row ">
						 <h4 class="list-group table-none-bordertop-item-heading">Available Drivers</h4>
						{!! Form::text('hours[3][drivers]', $weekly_schedule_de[3]->drivers, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

					</fieldset>
				</td>
			</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel panel-default each-day">
		<div class="panel-heading" role="tab" id="headingThur">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThur" aria-expanded="false" aria-controls="collapseThur">
					Thursday <span class="day-error-container day-error-container-4 pull-right hide"><span class="day-error-number day-error-number-4"></span> Errors <i class="glyphicon glyphicon-remove"></i></span>
					<span class="day-success-container day-success-container-4 pull-right hide"> <i class="glyphicon glyphicon-ok"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapseThur" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThur">
			<div class="panel-body daybox">
				<table class="table  table-condensed step-1" style="margin-bottom: 0;">
					<tbody>
						<tr class="">
				<td class="weekly-days-td">
					<strong>Thursday</strong>
					<div class="radio">
						<label>
							<input type="radio" name="hours[4][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" 
							@if($weekly_schedule_de[4]->open == 'open')
								checked="true"
							@endif
							>
							Open
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="hours[4][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" 
							@if($weekly_schedule_de[4]->open == 'closed')
								checked="true"
							@endif
							>
							Closed
						</label>
					</div>
				</td>
				<td class="list-group table-none-bordertop">
					<fieldset>
						<div class="list-group table-none-bordertop-item" style="height:85px;">
							<h4 class="list-group table-none-bordertop-item-heading">Start</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][open_hour]', $hours, $weekly_schedule_de[4]->open_hour, array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][open_minute]', $minutes, $weekly_schedule_de[4]->open_minute, array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][open_ampm]', $ampm, $weekly_schedule_de[4]->open_ampm, array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>
							</div>

						</div>
						<div class="list-group table-none-bordertop-item" style="height:85px;">
							<h4 class="list-group table-none-bordertop-item-heading">End</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][close_hour]', $hours, $weekly_schedule_de[4]->close_hour, array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][close_minute]', $minutes, $weekly_schedule_de[4]->close_minute, array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][close_ampm]', $ampm, $weekly_schedule_de[4]->close_ampm, array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>
							</div>
							<span class="time-error time-error-5 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>


												<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="4">
						<h4 class="list-group table-none-bordertop-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][break][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][break][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][break][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][break][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">
						  	@if(isset($weekly_schedule_de[4]->breaks_html))
								{!! $weekly_schedule_de[4]->breaks_html !!}
							@endif
						  </div>
					</div>

					<div class="form-group {{ $errors->has('drivers') ? 'has-error' : false }} row ">
						 <h4 class="list-group table-none-bordertop-item-heading">Available Drivers</h4>
						{!! Form::text('hours[4][drivers]', $weekly_schedule_de[4]->drivers, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

					</fieldset>
				</td>
			</tr>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel panel-default each-day">
		<div class="panel-heading" role="tab" id="headingFri">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFri" aria-expanded="false" aria-controls="collapseFri">
					Friday <span class="day-error-container day-error-container-6 pull-right hide"><span class="day-error-number day-error-number-6"></span> Errors <i class="glyphicon glyphicon-remove"></i></span>
					<span class="day-success-container day-success-container-6 pull-right hide"> <i class="glyphicon glyphicon-ok"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapseFri" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFri">
			<div class="panel-body daybox">
				<table class="table  table-condensed step-1" style="margin-bottom: 0;">
					<tbody>
	<tr class="">
				<td class="weekly-days-td">
					<strong>Friday</strong>
					<div class="radio">
						<label>
							<input type="radio" name="hours[5][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" 
						@if($weekly_schedule_de[5]->open == 'open')
							checked="true"
						@endif
							>
							Open
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="hours[5][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio"
							@if($weekly_schedule_de[5]->open == 'closed')
								checked="true"
							@endif
							>
							Closed
						</label>
					</div>
				</td>
				<td class="list-group table-none-bordertop">
					<fieldset>
						<div class="list-group table-none-bordertop-item" style="height:85px;">
							<h4 class="list-group table-none-bordertop-item-heading">Start</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][open_hour]', $hours, $weekly_schedule_de[5]->open_hour, array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][open_minute]', $minutes, $weekly_schedule_de[5]->open_minute, array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][open_ampm]', $ampm, $weekly_schedule_de[5]->open_ampm, array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>

						</div>
						<div class="list-group table-none-bordertop-item" style="height:85px;">
							<h4 class="list-group table-none-bordertop-item-heading">End</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][close_hour]', $hours, $weekly_schedule_de[5]->close_hour, array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][close_minute]', $minutes, $weekly_schedule_de[5]->close_minute, array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>


							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][close_ampm]', $ampm, $weekly_schedule_de[5]->close_ampm, array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
								<span class="time-error time-error-6 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>


					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="5">
						<h4 class="list-group table-none-bordertop-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][break][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][break][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][break][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][break][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">
						  	@if(isset($weekly_schedule_de[5]->breaks_html))
								{!! $weekly_schedule_de[5]->breaks_html !!}
							@endif
						  </div>
					</div>


					<div class="form-group {{ $errors->has('drivers') ? 'has-error' : false }} row ">
						 <h4 class="list-group table-none-bordertop-item-heading">Available Drivers</h4>
						{!! Form::text('hours[5][drivers]', $weekly_schedule_de[5]->drivers, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

					</fieldset>
				</td>
			</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel panel-default each-day">
		<div class="panel-heading" role="tab" id="headingSat">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSat" aria-expanded="false" aria-controls="collapseSat">
					Saturday  <span class="day-error-container day-error-container-7 pull-right hide"><span class="day-error-number day-error-number-7"></span> Errors <i class="glyphicon glyphicon-remove"></i></span>
					<span class="day-success-container day-success-container-7 pull-right hide"> <i class="glyphicon glyphicon-ok"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapseSat" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSat">
			<div class="panel-body daybox">
				<table class="table  table-condensed step-1" style="margin-bottom: 0;">
					<tbody>
						
	<tr class="">
				<td class="weekly-days-td">
					<strong>Saturday</strong>
					<div class="radio">
						<label>
							<input type="radio" name="hours[6][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" 
							@if($weekly_schedule_de[6]->open == 'open')
								checked="true"
							@endif
							>
							Open
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="hours[6][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" 
							@if($weekly_schedule_de[6]->open == 'closed')
								checked="true"
							@endif
							>
							Closed
						</label>
					</div>
				</td>
				<td class="list-group table-none-bordertop">
					<fieldset>
						<div class="list-group table-none-bordertop-item" style="height:85px;">
							<h4 class="list-group table-none-bordertop-item-heading">Start</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][open_hour]', $hours, $weekly_schedule_de[6]->open_hour, array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][open_minute]', $minutes, $weekly_schedule_de[6]->open_minute, array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][open_ampm]', $ampm, $weekly_schedule_de[6]->open_ampm, array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>

						</div>
						<div class="list-group table-none-bordertop-item" style="height:85px;">
							<h4 class="list-group table-none-bordertop-item-heading">End</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][close_hour]', $hours, $weekly_schedule_de[6]->close_hour, array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][close_minute]', $minutes, $weekly_schedule_de[6]->close_minute, array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][close_ampm]', $ampm, $weekly_schedule_de[6]->close_ampm, array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
								<span class="time-error time-error-7 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>

					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="6">
						<h4 class="list-group table-none-bordertop-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][break][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][break][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][break][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][break][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][break][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">
						  	@if(isset($weekly_schedule_de[6]->breaks_html))
								{!! $weekly_schedule_de[6]->breaks_html !!}
							@endif
						  </div>
					</div>
					<div class="form-group {{ $errors->has('drivers') ? 'has-error' : false }} row ">
						 <h4 class="list-group table-none-bordertop-item-heading">Available Drivers</h4>
						{!! Form::text('hours[6][drivers]', $weekly_schedule_de[6]->drivers, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

					</fieldset>
				</td>
			</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
