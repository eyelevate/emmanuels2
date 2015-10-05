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
		<h1>User Edit</h1>
		<ol class="breadcrumb">
			<li class="active">User Edit</li>
			<li><a href="/admins">Users Overview</a></li>
		</ol>
	</div>
	{!! Form::open(array('action' => 'UsersController@postEdit', 'class'=>'','role'=>"form")) !!}
	{!! Form::hidden('id',$admins['id']) !!}
	<div id="admin-info" class="panel panel-success">
	<div class="panel-body">
	<div class="form-group {!! $errors->has('roles') ? 'has-error' : false !!}">
	    <label class="control-label" for="roles">Roles</label>
    	<!-- {!! Form::select('roles', $roles, '1') !!} -->
    	{!! Form::select('roles', $roles, $admins->roles, array('class'=>'form-control','not_empty'=>'true')); !!}
	</div>
	<div class="form-group {!! $errors->has('username') ? 'has-error' : false !!}">
		<label class="control-label" for="username">Username</label>
		{!! Form::text('username', $admins->username, array('class'=>'form-control', 'placeholder'=>'Username')) !!}
		@foreach($errors->get('username') as $message)
		<span class='help-block'>{!! $message !!}</span>
		@endforeach
	</div>
		  	
	<div class="form-group {!! $errors->has('firstname') ? 'has-error' : false !!}">
	<label class="control-label" for="firstname">First Name</label>
		{!! Form::text('firstname', $admins->firstname, array('class'=>'form-control', 'placeholder'=>'First Name')) !!}
		@foreach($errors->get('firstname') as $message)
		<span class='help-block'>{!! $message !!}</span>
		@endforeach
	</div>

	<div class="form-group {!! $errors->has('lastname') ? 'has-error' : false !!}">
		<label class="control-label" for="lastname">Last Name</label>
		{!! Form::text('lastname', $admins->lastname, array('class'=>'form-control', 'placeholder'=>'Last Name')) !!}
		@foreach($errors->get('lastname') as $message)
			<span class='help-block'>{!! $message !!}</span>
		@endforeach
	</div>	 	
		  	
	<div class="form-group {!! $errors->has('email') ? 'has-error' : false !!}">
	  <label class="control-label" for="email">Email</label>
	  	{!! Form::text('email', $admins->email, array('class'=>'form-control', 'placeholder'=>'Email Address')) !!}
	  	@foreach($errors->get('email') as $message)
	    <span class='help-block'>{!! $message !!}</span>
		@endforeach
	</div>	  
	<div class="well well-sm">
		<kbd><em>Update Password</em></kbd><br/><br/>
		<div class="form-group {!! $errors->has('password') ? 'has-error' : false !!}">
			<label class="control-label" for="password">New Password</label>
			{!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) !!}
			@foreach($errors->get('password') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>	
		<div class="form-group {!! $errors->has('password') ? 'has-error' : false !!}">
			<label class="control-label" for="password_confirmation">Re-enter New Password</label>
			{!! Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) !!}
			@foreach($errors->get('password_confirmation') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
		</div>    	
	</div>
		<div class="panel-footer clearfix">
			{!! Form::submit('Update', array('class'=>'btn btn-large btn-primary pull-right'))!!}
		</div>
	</div>

	</div>


@stop