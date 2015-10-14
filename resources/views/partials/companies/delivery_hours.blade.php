<?php
$hours = array();
$minutes = array();
$ampm = array('am'=>'am','pm'=>'pm');
for ($i=0; $i < 13; $i++) { 
	if ($i == 0) {
		$hours[$i] = 'Select hour';
	} else if($i < 10){
		$hours['0'.$i] = $i;
	} else {
		$hours[$i] = $i;
	}
}
for ($i=0; $i <= 60; $i++) {
	if($i == 0) {
		$minutes[""] = 'Select minute';
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
			<td>
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
					<div class="list-group-item" style="height:107px;">
						<h4 class="list-group-item-heading">Start</h4>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[0][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[0][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[0][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>
						</div>

					</div>
					<div class="list-group-item" style="height:107px;">
						<h4 class="list-group-item-heading">End</h4>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[0][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[0][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[0][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'1','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<span class="time-error time-error-1 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
					</div>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td>
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
					<div class="list-group-item" style="height:107px;">
						<h4 class="list-group-item-heading">Start</h4>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[1][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[1][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[1][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group-item" style="height:107px;">
						<h4 class="list-group-item-heading">End</h4>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[1][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[1][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[1][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'2','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<span class="time-error time-error-2 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
					</div>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td>
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
					<div class="list-group-item" style="height:107px;">
						<h4 class="list-group-item-heading">Start</h4>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[2][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[2][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[2][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group-item" style="height:107px;">
						<h4 class="list-group-item-heading">End</h4>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[2][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[2][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[2][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'3','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>
						<span class="time-error time-error-3 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
					</div>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td>
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
					<div class="list-group-item" style="height:107px;">
						<h4 class="list-group-item-heading">Start</h4>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[3][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[3][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[3][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
							</div>					
						</div>

					</div>
					<div class="list-group-item" style="height:107px;">
						<h4 class="list-group-item-heading">End</h4>
						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[3][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
								<div class="select-error hide" style="color:#a94442">The hour field is required</div>
							</div>					
						</div>

						<div class="col-xs-4">
							<div class="form-group ">
								{!! Form::select('hours[3][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">The minute field is required</div>
							</div>					
						</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[3][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'4','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
							<span class="time-error time-error-4 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
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
						<div class="list-group-item" style="height:107px;">
							<h4 class="list-group-item-heading">Start</h4>
							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[4][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[4][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[4][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
								<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>
							</div>

						</div>
						<div class="list-group-item" style="height:107px;">
							<h4 class="list-group-item-heading">End</h4>
							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[4][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[4][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[4][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'5','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>
							</div>
							<span class="time-error time-error-5 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
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
						<div class="list-group-item" style="height:107px;">
							<h4 class="list-group-item-heading">Start</h4>
							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[5][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[5][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[5][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>

						</div>
						<div class="list-group-item" style="height:107px;">
							<h4 class="list-group-item-heading">End</h4>
							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[5][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[5][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>


							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[5][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'6','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
								<span class="time-error time-error-6 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
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
						<div class="list-group-item" style="height:107px;">
							<h4 class="list-group-item-heading">Start</h4>
							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[6][open_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[6][open_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[6][open_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>

						</div>
						<div class="list-group-item" style="height:107px;">
							<h4 class="list-group-item-heading">End</h4>
							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[6][close_hour]', $hours, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
									<div class="select-error hide" style="color:#a94442">The hour field is required</div>
								</div>					
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[6][close_minute]', $minutes, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">The minute field is required</div>
								</div>					
							</div>

							<div class="col-xs-4">
								<div class="form-group ">
									{!! Form::select('hours[6][close_ampm]', $ampm, '', array('class'=>'form-control form-selects','this_category'=>'7','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
									<div class="select-error hide" style="color:#a94442">This field is required</div>
								</div>					
							</div>
								<span class="time-error time-error-7 hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
						</div>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>