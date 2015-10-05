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
	{!! Form::open(array('action' => 'CompaniesController@postAdd', 'class'=>'','role'=>"form")) !!}
	<div id="step1" class="panel panel-default">
		
		<div class="panel-heading">
			<h4>General Company Information <span class="glyphicon glyphicon-info-sign"></span></h4>
		</div>
		<div id="step1_panel" class="panel-body">
		

		  	<div class="form-group {!! $errors->has('name') ? 'has-error has-feedback' : false !!}">
		  		{!! Form::label('name', 'Company Name', array('class' => 'control-label','style="width:100%;')) !!}
		    	{!! Form::text('name', null, array('class'=>'form-control', 'not_empty'=>'true', 'placeholder'=>'Official Name of Company')) !!}
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
		    	{!! Form::text('phone', null, array('class'=>'form-control form-phone', 'placeholder'=>'eg ### ### ####')) !!}
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
		    	{!! Form::text('email', null, array('class'=>'form-control', 'not_empty'=>'false', 'placeholder'=>'example xxxx@xxx.com')) !!}
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
		    	{!! Form::text('street', null, array('class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Street Address')) !!}
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
		    	{!! Form::text('zipcode', null, array('class'=>'form-control', 'not_empty'=>'true', 'placeholder'=>'Zipcode')) !!}
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
		    	{!! Form::text('city', null, array('class'=>'form-control', 'not_empty'=>'true', 'placeholder'=>'City','data-provide'=>'typeahead', 'autocomplete'=>'off')) !!}
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
		    	{!! Form::text('state', null, array('class'=>'form-control','not_empty'=>'true', 'placeholder'=>'State')) !!}
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
		    	{!! Form::text('region', null, array('class'=>'form-control', 'placeholder'=>'region')) !!}
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
		    	{!! Form::select('country', $country_code, 'US', array('class'=>'form-control','not_empty'=>'true')); !!}

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
		    	{!! Form::text('url', '', array('class'=>'form-control', 'not_empty'=>'false', 'placeholder'=>'Please enter a valid url','readonly'=>true)) !!}
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
		  		{!! View::make('partials.companies.store_hours_schedule_limits') !!}
		  	</div>
		</div>
	</div>

	<div id="step4" class="row-fluid clearfix" >
		<input type="submit" value="Validate Company" class="btn btn-primary btn-large pull-right"/>

	</div>
	<br/>

	{!! Form::close() !!}
@stop
