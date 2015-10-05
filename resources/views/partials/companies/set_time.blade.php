
<div class="formRow form-group">
	<div class="radio {{ $errors->has('data[Company][store_hours][$idx][type]') ? 'has-error' : false }}">
    	<label class="control-label" for="data[Company][store_hours][{{ $idx }}][type]">{{ Form::radio('data[Company][store_hours]['.$idx.'][type]', 'Closed', false, array('class'=>'closed')) }} Closed</label>

    	
        @foreach($errors->get('data[Company][store_hours]['.$idx.'][type]') as $message)
            <span class='help-block'>{{ $message }}</span>
            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
        @endforeach
        <span class='help-block hide'></span>
        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
  	</div>
</div>
<div class="formRow form-group">
	<div class="radio {{ $errors->has('data[Company][store_hours][$idx][type]') ? 'has-error' : false }}">
    	<label class="control-label" for="data[Company][{{ $idx }}][hours_type]">{{ Form::radio('data[Company][store_hours]['.$idx.'][type]', '24',false,array('class'=>'twentyfour')) }} Open 24 hours</label>

    	
        @foreach($errors->get('data[Company][store_hours]['.$idx.'][type]') as $message)
            <span class='help-block'>{{ $message }}</span>
            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
        @endforeach
        <span class='help-block hide'></span>
        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
  	</div>
</div>
<div class="formRow form-group">
	<div class="radio {{ $errors->has('data[Company][store_hours][$idx][type]') ? 'has-error' : false }}">
    	<label class="control-label" for="data[Company][store_hours][{{ $idx }}][type]">{{ Form::radio('data[Company][store_hours]['.$idx.'][type]', 'between', false ,array('class'=>'between')) }} Between the hours of..</label>

    	
        @foreach($errors->get('data[Company][store_hours]['.$idx.'][type]') as $message)
            <span class='help-block'>{{ $message }}</span>
            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
        @endforeach
        <span class='help-block hide'></span>
        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
  	</div>
</div>
<div class="well well-sm timeSet hide">
	<h3 class="betweenHoursTitle">
		<span class="open_hours_span" status="false">Not Set (Open Hours)</span>
		<span class="open_ampm_span" status="false"></span> 
		- 
		<span class="closed_hours_span" status="false">Not Set (Closed Hours)</span>
		<span class="closed_ampm_span" status="false"></span>
	</h3>
	<div class="row">					
		<div class="form-group {{ $errors->has('data[Company][store_hours][$idx][opens]') ? 'has-error' : false }} col-md-8">
	    	<label class="control-label" for="data[Company][store_hours][{{ $idx }}][opens]">Opens At</label>

	    	{{ Form::select('data[Company][store_hours]['.$idx.'][opens]', $time,null,array('class'=>'form-control open_hours')) }}

	        <span class='help-block hide'></span>
	        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
	  	</div>
	  	<div class="form-group {{ $errors->has('data[Company][store_hours][$idx]][opens_ampm]') ? 'has-error' : false }} col-md-4">
	    	<label class="control-label" for="data[Company][store_hours][{{ $idx }}][opens_ampm]">AM / PM</label>

	    	{{ Form::select('data[Company][store_hours]['.$idx.'][opens_ampm]', array(''=>'select AM / PM','AM' => 'AM', 'PM' => 'PM'),null,array('class'=>'form-control open_ampm')) }}

	        <span class='help-block hide'></span>
	        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
	  	</div>
	</div>
	<div class="row">
	  	<div class="form-group {{ $errors->has('data[Company][store_hours][$idx]][closes]') ? 'has-error' : false }} col-md-8">
	    	<label class="control-label" for="data[Company][store_hours][{{ $idx }}][closes]">Closes At</label>

	    	{{ Form::select('data[Company][store_hours]['.$idx.'][closes]', $time,null,array('class'=>'form-control closed_hours')) }}

	        <span class='help-block hide'></span>
	        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
	  	</div>
	  	<div class="form-group {{ $errors->has('data[Company][store_hours][$idx]][closes_ampm]') ? 'has-error' : false }} col-md-4">
	    	<label class="control-label" for="data[Company][store_hours][{{ $idx }}][closes_ampm]">AM / PM</label>

	    	{{ Form::select('data[Company][store_hours]['.$idx.'][closes_ampm]', array(''=>'select AM / PM','AM' => 'AM', 'PM' => 'PM'),null,array('class'=>'form-control closed_ampm')) }}

	        <span class='help-block hide'></span>
	        <span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
	  	</div>
	</div>
</div>
