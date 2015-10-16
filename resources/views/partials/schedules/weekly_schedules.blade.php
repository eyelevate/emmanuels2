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

<table class="table table-bordered table-condensed step-1">
	<tbody>
		<tr>
			<td class="weekly-days-td">
				<strong>Sunday</strong>
				<div class="radio">
					<label>
						<input type="radio" name="hours[0][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" >
						Open
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="hours[0][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" checked="true">
						Closed
					</label>
				</div>
			</td>
			<td class="list-group">
				<fieldset>
					<div class="list-group-item" style="height:85px;">
						<h4 class="list-group-item-heading">Start</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							
							</div>
						</div>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>
						</div>

					</div>
					<div class="list-group-item" style="height:85px;">
						<h4 class="list-group-item-heading">End</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<span class="time-error time-error-1 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
					</div>


					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="0">
						<h4 class="list-group-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[0][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">

						  </div>
					</div>
					
					<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
						<h4 class="list-group-item-heading">Available Drivers</h4>
						{!! Form::text('hours[0][drivers]', null, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>




				</fieldset>
			</td>
		</tr>
		<tr>
			<td class="weekly-days-td">
				<strong>Monday</strong>
				<div class="radio">
					<label>
						<input type="radio" name="hours[1][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" >
						Open
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="hours[1][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" checked="true">
						Closed
					</label>
				</div>
			</td>
			<td class="list-group">
				<fieldset>
					<div class="list-group-item" style="height:85px;">
						<h4 class="list-group-item-heading">Start</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group-item" style="height:85px;">
						<h4 class="list-group-item-heading">End</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<span class="time-error time-error-2 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
					</div>

					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="1">
						<h4 class="list-group-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[1][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">

						  </div>
					</div>
					<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
						<label class="control-label" for="drivers">Available Drivers</label>
						{!! Form::text('hours[1][drivers]', null, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td class="weekly-days-td">
				<strong>Tuesday</strong>
				<div class="radio">
					<label>
						<input type="radio" name="hours[2][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" >
						Open
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="hours[2][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" checked="true">
						Closed
					</label>
				</div>
			</td>
			<td class="list-group">
				<fieldset>
					<div class="list-group-item" style="height:85px;">
						<h4 class="list-group-item-heading">Start</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group-item" style="height:85px;">
						<h4 class="list-group-item-heading">End</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<span class="time-error time-error-3 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
					</div>




					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="2">
						<h4 class="list-group-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[2][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">

						  </div>
					</div>




					<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
						<label class="control-label" for="drivers">Available Drivers</label>
						{!! Form::text('hours[2][drivers]', null, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

				</fieldset>
			</td>
		</tr>
		<tr>
			<td class="weekly-days-td">
				<strong>Wednesday</strong>
				<div class="radio">
					<label>
						<input type="radio" name="hours[3][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" >
						Open
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="hours[3][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" checked="true">
						Closed
					</label>
				</div>
			</td>
			<td class="list-group">
				<fieldset>
					<div class="list-group-item" style="height:85px;">
						<h4 class="list-group-item-heading">Start</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group-item" style="height:85px;">
						<h4 class="list-group-item-heading">End</h4>
						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[3][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
							<span class="time-error time-error-4 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>




					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="3">
						<h4 class="list-group-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[3][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">

						  </div>
					</div>







					<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
						<label class="control-label" for="drivers">Available Drivers</label>
						{!! Form::text('hours[3][drivers]', null, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="weekly-days-td">
					<strong>Thursday</strong>
					<div class="radio">
						<label>
							<input type="radio" name="hours[4][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" >
							Open
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="hours[4][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" checked="true">
							Closed
						</label>
					</div>
				</td>
				<td class="list-group">
					<fieldset>
						<div class="list-group-item" style="height:85px;">
							<h4 class="list-group-item-heading">Start</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>
							</div>

						</div>
						<div class="list-group-item" style="height:85px;">
							<h4 class="list-group-item-heading">End</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[4][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>
							</div>
							<span class="time-error time-error-5 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>
						<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="4">
						<h4 class="list-group-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[4][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">

						  </div>
					</div>

					<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
						<label class="control-label" for="drivers">Available Drivers</label>
						{!! Form::text('hours[4][drivers]', null, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="weekly-days-td">
					<strong>Friday</strong>
					<div class="radio">
						<label>
							<input type="radio" name="hours[5][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" >
							Open
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="hours[5][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" checked="true">
							Closed
						</label>
					</div>
				</td>
				<td class="list-group">
					<fieldset>
						<div class="list-group-item" style="height:85px;">
							<h4 class="list-group-item-heading">Start</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>

						</div>
						<div class="list-group-item" style="height:85px;">
							<h4 class="list-group-item-heading">End</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>


							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[5][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
								<span class="time-error time-error-6 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>






					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="5">
						<h4 class="list-group-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[5][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">

						  </div>
					</div>





					<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
						<label class="control-label" for="drivers">Available Drivers</label>
						{!! Form::text('hours[5][drivers]', null, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
						<div class="select-error hide" style="color:#a94442">This field is required</div>
						@foreach($errors->get('drivers') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>

					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="weekly-days-td">
					<strong>Saturday</strong>
					<div class="radio">
						<label>
							<input type="radio" name="hours[6][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" >
							Open
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="hours[6][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" checked="true">
							Closed
						</label>
					</div>
				</td>
				<td class="list-group">
					<fieldset>
						<div class="list-group-item" style="height:85px;">
							<h4 class="list-group-item-heading">Start</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>

						</div>
						<div class="list-group-item" style="height:85px;">
							<h4 class="list-group-item-heading">End</h4>
							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4 w_s_container">
								<div class="form-group  form-group-error-not">
									{!! Form::select('hours[6][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
								<span class="time-error time-error-7 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>



					<div class=" row form-group {{ $errors->has('breaks') ? 'has-error' : false }} breaks-container" this-day="6">
						<h4 class="list-group-item-heading">Breaks</h4>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">From : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][close_hour]', $hours, '', array('class'=>'form-control form-break from-hour','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][close_minute]', $minutes, '', array('class'=>'form-control form-break from-minute','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][close_ampm]', $ampm, '', array('class'=>'form-control form-break from-ampm','id'=>'','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<label class="control-label" for="drivers" style="line-height: 32px;">To : 
							</label>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][close_hour]', $hours, '', array('class'=>'form-control form-break to-hour','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][close_minute]', $minutes, '', array('class'=>'form-control form-break to-minute','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>
						<div class="col-xs-3 w_s_container">
							<div class="form-group  form-group-error-not">
								{!! Form::select('hours[6][close_ampm]', $ampm, '', array('class'=>'form-control form-break to-ampm','this_category'=>'1','id'=>'','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<div class="alert alert-danger incomplete-break hide col-xs-12" role="alert">Incomplete Time</div>

						<div class="col-xs-12 w_s_container">
							<a class="btn btn-primary btn-block add-break-btn"  >Add</a>					
						</div>
						  <div class=" col-xs-12 breaks-div"  style="padding: 0;">

						  </div>
					</div>






					<div class="row form-group {{ $errors->has('drivers') ? 'has-error' : false }}">
						<label class="control-label" for="drivers">Available Drivers</label>
						{!! Form::text('hours[6][drivers]', null, array('class'=>'form-control form-selects drivers-text', 'placeholder'=>'Number of Available Drivers')) !!}
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