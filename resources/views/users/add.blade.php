@extends($layout)
@section('stylesheets')
{!! Html::style('packages/DataTables-Bootstrap3/BS3/assets/css/datatables.css') !!}
@stop

@section('scripts')
{!! Html::script('packages/DataTables-1.9.4/media/js/jquery.dataTables.min.js') !!}
{!! Html::script('packages/DataTables-Bootstrap3/BS3/assets/js/datatables.js') !!}	
@stop

@section('content')
<div class="jumbotron">
	<h1>User Add</h1>
	<ol class="breadcrumb">
		<li class="active">User Add</li>
		<li><a href="{!! action('AdminsController@getIndex') !!}">Users Overview</a></li>
	</ol>
</div>
{!! Form::open(array('action'=>'UsersController@postAdd', 'class'=>'form-signup','role'=>"form")) !!}
<div id="admin-info" class="panel panel-success">
	<div class="panel-body">
		<div class="form-group {!! $errors->has('username') ? 'has-error' : false !!}">
			<label class="control-label" for="roles">Roles</label>
			<!-- {!! Form::select('roles', $roles, '1') !!} -->
			{!! Form::select('roles', $roles, '1', array('class'=>'form-control','not_empty'=>'true')); !!}
			
		</div>

		<div class="form-group {!! $errors->has('username') ? 'has-error' : false !!}">
			<label class="control-label" for="username">Username</label>
			{!! Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Username')) !!}
			@foreach($errors->get('username') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
		<div class="form-group {!! $errors->has('firstname') ? 'has-error' : false !!}">
			<label class="control-label" for="firstname">First Name</label>
			{!! Form::text('firstname', null, array('class'=>'form-control', 'placeholder'=>'First Name')) !!}
			@foreach($errors->get('firstname') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
		<div class="form-group {!! $errors->has('lastname') ? 'has-error' : false !!}">
			<label class="control-label" for="lastname">Last Name</label>
			{!! Form::text('lastname', null, array('class'=>'form-control', 'placeholder'=>'Last Name')) !!}
			@foreach($errors->get('lastname') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>	 	
		<div class="form-group {!! $errors->has('email') ? 'has-error' : false !!}">
			<label class="control-label" for="email">Email</label>
			{!! Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) !!}
			@foreach($errors->get('email') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>	    
		<div class="form-group {!! $errors->has('password') ? 'has-error' : false !!}">
			<label class="control-label" for="password">Password</label>
			{!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) !!}
			@foreach($errors->get('password') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>	
		<div class="form-group {!! $errors->has('password') ? 'has-error' : false !!}">
			<label class="control-label" for="password_confirmation">Confirm Password</label>
			{!! Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) !!}
			@foreach($errors->get('password_confirmation') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
		{!! Form::submit('Register', array('class'=>'btn btn-large btn-primary btn-block'))!!}
		{!! Form::close() !!}
	</div>
</div>
@stop