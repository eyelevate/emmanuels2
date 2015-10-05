<?php
$hours = array();
$minutes = array();
$ampm = array('am'=>'am','pm'=>'pm');
for ($i=0; $i < 13; $i++) { 
	$hours[$i] = ($i == 0) ? 'Select hour' : $i;
}
for ($i=0; $i <= 60; $i++) {
	if($i == 0) {
		$minutes[""] = 'Select minute';
	} else {
		$minutes[$i-1] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
	}
}

?>	

<table class="table table-bordered table-condensed">
	<tbody>
		<tr>
			<td>
				<strong>Sunday</strong>
				<div class="radio">
			  <label>
			    <input type="radio" name="hours[0][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" checked="true">
			    Open
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="hours[0][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio">
			    Closed
			  </label>
			</div>
			</td>
			<td class="list-group">

				<fieldset>

				<div class="list-group-item" style="height:90px;">
					<h4 class="list-group-item-heading">Opens at</h4>
					<div class="col-xs-4">
						{!! Form::select('hours[0][open_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[0][open_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[0][open_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
				</div>
			  	<div class="list-group-item" style="height:90px;">
			  		<h4 class="list-group-item-heading">Closes at</h4>
			  		<div class="col-xs-4">
						{!! Form::select('hours[0][close_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[0][close_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[0][close_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
			  	</div>
		  	</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Monday</strong>
				<div class="radio">
			  <label>
			    <input type="radio" name="hours[1][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" checked="true">
			    Open
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="hours[1][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio">
			    Closed
			  </label>
			</div>
			</td>
			<td class="list-group">
				<fieldset>
				<div class="list-group-item" style="height:90px;">
					<h4 class="list-group-item-heading">Opens at</h4>
					<div class="col-xs-4">
						{!! Form::select('hours[1][open_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[1][open_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[1][open_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
				</div>
			  	<div class="list-group-item" style="height:90px;">
			  		<h4 class="list-group-item-heading">Closes at</h4>
			  		<div class="col-xs-4">
						{!! Form::select('hours[1][close_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[1][close_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[1][close_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
			  	</div>
			</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Tuesday</strong>
				<div class="radio">
			  <label>
			    <input type="radio" name="hours[2][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" checked="true">
			    Open
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="hours[2][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio">
			    Closed
			  </label>
			</div>
			</td>
			<td class="list-group">
				<fieldset>
				<div class="list-group-item" style="height:90px;">
					<h4 class="list-group-item-heading">Opens at</h4>
					<div class="col-xs-4">
						{!! Form::select('hours[2][open_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[2][open_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[2][open_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
				</div>
			  	<div class="list-group-item" style="height:90px;">
			  		<h4 class="list-group-item-heading">Closes at</h4>
			  		<div class="col-xs-4">
						{!! Form::select('hours[2][close_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[2][close_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[2][close_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
			  	</div>
		  	</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Wednesday</strong>
				<div class="radio">
			  <label>
			    <input type="radio" name="hours[3][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" checked="true">
			    Open
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="hours[3][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio">
			    Closed
			  </label>
			</div>
			</td>
			<td class="list-group">
				<fieldset>
				<div class="list-group-item" style="height:90px;">
					<h4 class="list-group-item-heading">Opens at</h4>
					<div class="col-xs-4">
						{!! Form::select('hours[3][open_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[3][open_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[3][open_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
				</div>
			  	<div class="list-group-item" style="height:90px;">
			  		<h4 class="list-group-item-heading">Closes at</h4>
			  		<div class="col-xs-4">
						{!! Form::select('hours[3][close_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[3][close_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[3][close_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
			  	</div>
		  	</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Thursday</strong>
				<div class="radio">
			  <label>
			    <input type="radio" name="hours[4][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" checked="true">
			    Open
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="hours[4][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio">
			    Closed
			  </label>
			</div>
			</td>
			<td class="list-group">
				<fieldset>
				<div class="list-group-item" style="height:90px;">
					<h4 class="list-group-item-heading">Opens at</h4>
					<div class="col-xs-4">
						{!! Form::select('hours[4][open_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[4][open_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[4][open_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
				</div>
			  	<div class="list-group-item" style="height:90px;">
			  		<h4 class="list-group-item-heading">Closes at</h4>
			  		<div class="col-xs-4">
						{!! Form::select('hours[4][close_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[4][close_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[4][close_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
			  	</div>
		  	</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Friday</strong>
				<div class="radio">
			  <label>
			    <input type="radio" name="hours[5][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" checked="true">
			    Open
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="hours[5][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio">
			    Closed
			  </label>
			</div>
			</td>
			<td class="list-group">
				<fieldset>
				<div class="list-group-item" style="height:90px;">
					<h4 class="list-group-item-heading">Opens at</h4>
					<div class="col-xs-4">
						{!! Form::select('hours[5][open_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[5][open_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[5][open_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
				</div>
			  	<div class="list-group-item" style="height:90px;">
			  		<h4 class="list-group-item-heading">Closes at</h4>
			  		<div class="col-xs-4">
						{!! Form::select('hours[5][close_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[5][close_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[5][close_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
			  	</div>
		  	</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Saturday</strong>
				<div class="radio">
			  <label>
			    <input type="radio" name="hours[6][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" checked="true">
			    Open
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="hours[6][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio">
			    Closed
			  </label>
			</div>
			</td>
			<td class="list-group">
				<fieldset>
				<div class="list-group-item" style="height:90px;">
					<h4 class="list-group-item-heading">Opens at</h4>
					<div class="col-xs-4">
						{!! Form::select('hours[6][open_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[6][open_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[6][open_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
				</div>
			  	<div class="list-group-item" style="height:90px;">
			  		<h4 class="list-group-item-heading">Closes at</h4>
			  		<div class="col-xs-4">
						{!! Form::select('hours[6][close_hour]', $hours, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[6][close_minute]', $minutes, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('hours[6][close_ampm]', $ampm, '', array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
					</div>
			  	</div>
		  	</fieldset>
			</td>
		</tr>
	</tbody>
</table>