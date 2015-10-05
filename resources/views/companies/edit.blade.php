@extends($layout)
@section('stylesheets')
	{!! Html::style('packages/intl-tel-input/build/css/intlTelInput.css') !!}
@stop
@section('scripts')
	{!! Html::script('packages/intl-tel-input/lib/libphonenumber/build/isValidNumber.js') !!}
	{!! Html::script('packages/intl-tel-input/build/js/intlTelInput.js') !!}
	{!! Html::script('packages/numeric/jquery.numeric.js') !!}
	
	{!! Html::script('js/company_edit.js') !!}
@stop
@section('content')
	<div class="jumbotron">
		<h1>Edit Company Info</h1>
		<ol class="breadcrumb">
		  	<li><a href="/companies/view/{!! $companies['id'] !!}">View Company</a></li>
		  	<li class="active">Edit Company</li>
		</ol>
<!-- 		<ol class="breadcrumb">
			<li><a href="/menus">View Menu</a></li>
			<li><a href="/menus/edit/{!! $companies['id'] !!}">Update Menu</a></li>
		</ol> -->
	</div>
	{!! Form::open(array('action' => 'CompaniesController@postEdit', 'class'=>'','role'=>"form")) !!}
	{!! Form::hidden('id', $companies['id']) !!}
	<div id="step1" class="panel panel-default">
		
		<div class="panel-heading">
			<h4>General Company Information <span class="glyphicon glyphicon-info-sign"></span></h4>
		</div>
		<div id="step1_panel" class="panel-body">
		

		  	<div class="form-group {!! $errors->has('name') ? 'has-error has-feedback' : false !!}">
		  		{!! Form::label('name', 'Company Name', array('class' => 'control-label','style="width:100%;')) !!}
		    	{!! Form::text('name', $companies['name'], array('class'=>'form-control', 'not_empty'=>'true', 'placeholder'=>'Official Name of Company')) !!}
		        @foreach($errors->get('name') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>

		  	<div class="form-group {!! $errors->has('phone') ? 'has-error has-feedback' : false !!}">
		    	{!! Form::label('phone', 'Phone Number', array('class' => 'control-label')) !!}
		    	{!! Form::text('phone', $companies['phone'], array('class'=>'form-control form-phone', 'placeholder'=>'eg ### ### ####')) !!}
		        @foreach($errors->get('phone') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>
		  	<div class="form-group {!! $errors->has('email') ? 'has-error has-feedback' : false !!}">
		    	<label class="control-label" for="nick_name">Company Email </label>
		    	{!! Form::text('email', $companies['email'], array('class'=>'form-control', 'not_empty'=>'false', 'placeholder'=>'example xxxx@xxx.com')) !!}
		        @foreach($errors->get('email') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>
		  	<div class="form-group {!! $errors->has('street') ? 'has-error has-feedback' : false !!}">
		    	{!! Form::label('street', 'Street Address', array('class' => 'control-label')) !!}
		    	{!! Form::text('street', $companies['street'], array('class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Street Address')) !!}
		        @foreach($errors->get('street') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		       	@if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>	  
		  	<div class="form-group {!! $errors->has('zipcode') ? 'has-error has-feedback' : false !!}">
		    	{!! Form::label('zipcode', 'Zipcode / Postal Code', array('class' => 'control-label')) !!}
		    	{!! Form::text('zipcode', $companies['zipcode'], array('class'=>'form-control', 'not_empty'=>'true', 'placeholder'=>'Zipcode')) !!}
		        @foreach($errors->get('zipcode') as $message)
		            <span class='help-block hide'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>
		  	<div class="form-group {!! $errors->has('city') ? 'has-error has-feedback' : false !!}">
		    	{!! Form::label('city', 'City', array('class' => 'control-label')) !!}
		    	{!! Form::text('city', $companies['city'], array('class'=>'form-control', 'not_empty'=>'true', 'placeholder'=>'City','data-provide'=>'typeahead', 'autocomplete'=>'off')) !!}
		        @foreach($errors->get('city') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>	
		  	<div class="form-group {!! $errors->has('state') ? 'has-error has-feedback' : false !!}">
		    	<label class="control-label" for="state">State <small><em>(If applicable)</em></small></label>
		    	{!! Form::text('state', $companies['state'], array('class'=>'form-control','not_empty'=>'true', 'placeholder'=>'State')) !!}
		        @foreach($errors->get('state') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>	
		  	<div class="form-group {!! $errors->has('region') ? 'has-error has-feedback' : false !!}">
		    	<label class="control-label" for="region">Region / Territory <small><em>(If applicable)</em></small></label>
		    	{!! Form::text('region', $companies['region'], array('class'=>'form-control', 'placeholder'=>'region')) !!}
		        @foreach($errors->get('region') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>	
		  	<div class="form-group {!! $errors->has('country') ? 'has-error has-feedback' : false !!}">
		    	{!! Form::label('country', 'Country', array('class' => 'control-label')) !!}
		    	{!! Form::select('country', $country_code, $companies['country'], array('class'=>'form-control','not_empty'=>'true')); !!}

		        @foreach($errors->get('country') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>		

		</div>
	</div>
	<div id="step2" class="panel panel-default">
		
		<div class="panel-heading">
			<h4>Detailed Company Information <span class="glyphicon glyphicon-info-sign"></span></h4>
		</div>
		<div id="step2_panel" class="panel-body">
		  	<div class="form-group {!! $errors->has('url') ? 'has-error has-feedback' : false !!}">
		    	<label class="control-label" for="url">Company Url</label>
		    	{!! Form::text('url', $companies['url'], array('class'=>'form-control', 'not_empty'=>'false', 'placeholder'=>'Please enter a valid url','readonly'=>true)) !!}
		        @foreach($errors->get('url') as $message)
		            <span class='help-block'>{!! $message !!}</span>
		            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
		        @endforeach
		        @if(count($errors) == 0)
		        <span class='help-block hide'></span>
		        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
		  		@endif
		  	</div>
		  	<div class="form-group">
		  		<label class="control-label">Company Hours</label>
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
		  				@if(!empty($companies['store_hours']))
			  				<?php
			  				$idx = -1;
			  				foreach($companies['store_hours'] as $key => $value):
			  					$idx++;
					  			$check_opened = ($companies['store_hours'][$key]['status'] == 'open') ? 'checked' : '';
					  			$check_closed = ($companies['store_hours'][$key]['status'] == 'closed') ? 'checked' : '';
					  			$make_disabled = ($companies['store_hours'][$key]['status'] == 'closed') ? 'disabled="disabled"' : '';
					  			$open_hours = ($companies['store_hours'][$key]['status'] == 'open') ? date('h',strtotime(date('n/d/Y ').$companies['store_hours'][$key]['open'])) : 0;
					  			$closed_hours = ($companies['store_hours'][$key]['status'] == 'open') ? date('h',strtotime(date('n/d/Y ').$companies['store_hours'][$key]['close'])) : 0;
					  			$open_minutes = ($companies['store_hours'][$key]['status'] == 'open') ? date('i',strtotime(date('n/d/Y ').$companies['store_hours'][$key]['open'])) : '';
					  			$closed_minutes = ($companies['store_hours'][$key]['status'] == 'open') ? date('i',strtotime(date('n/d/Y ').$companies['store_hours'][$key]['close'])) : '';
					  			$open_ampm = ($companies['store_hours'][$key]['status'] == 'open') ? date('a',strtotime(date('n/d/Y ').$companies['store_hours'][$key]['open'])) : 'am';
					  			$closed_ampm = ($companies['store_hours'][$key]['status'] == 'open') ? date('a',strtotime(date('n/d/Y ').$companies['store_hours'][$key]['close'])) : 'am';
			  				?>
			  				<tr>
			  					<td>
			  						<strong>{!! $key !!}</strong>
			  						<div class="radio">
									  <label>
									    <input type="radio" name="hours[{!! $idx !!}][open]" id="optionsRadios1" value="open" class="hoursOpenRadio" {!! $check_opened !!}>
									    Open
									  </label>
									</div>
									<div class="radio">
									  <label>
									    <input type="radio" name="hours[{!! $idx !!}][open]" id="optionsRadios2" value="closed" class="hoursOpenRadio" {!! $check_closed !!}>
									    Closed
									  </label>
									</div>
			  					</td>
			  					<td class="list-group">
			  						<fieldset {!! $make_disabled !!}>
										<div class="list-group-item" style="height:90px;">
											<h4 class="list-group-item-heading">Opens at</h4>
											<div class="col-xs-4">
												{!! Form::select('hours['.$idx.'][open_hour]', $hours, $open_hours, array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
											</div>
											<div class="col-xs-4">
												{!! Form::select('hours['.$idx.'][open_minute]', $minutes, $open_minutes, array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
											</div>
											<div class="col-xs-4">
												{!! Form::select('hours['.$idx.'][open_ampm]', $ampm, $open_ampm, array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
											</div>
										</div>
									  	<div class="list-group-item" style="height:90px;">
									  		<h4 class="list-group-item-heading">Closes at</h4>
									  		<div class="col-xs-4">
												{!! Form::select('hours['.$idx.'][close_hour]', $hours, $closed_hours, array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Hour')); !!}
											</div>
											<div class="col-xs-4">
												{!! Form::select('hours['.$idx.'][close_minute]', $minutes, $closed_minutes, array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
											</div>
											<div class="col-xs-4">
												{!! Form::select('hours['.$idx.'][close_ampm]', $ampm, $closed_ampm, array('class'=>'form-control','not_empty'=>'true','placeholder'=>'Select Minute')); !!}
											</div>
									  	</div>
								  	</fieldset>
			  					</td>
			  				</tr>
			  				<?php
			  				endforeach;
			  				?>
			  			@else
			  				{!! View::make('partials.companies.store_hours') !!}
			  			@endif
		  			</tbody>
		  		</table>
		  	</div>
		</div>
	</div>

	<div id="step4" class="row-fluid clearfix" >
		<input type="submit" value="Update" class="btn btn-primary btn-large pull-right"/>

	</div>
	<br/>

	{!! Form::close() !!}
@stop
