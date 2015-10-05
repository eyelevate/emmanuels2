@section('stylesheets')

@stop

@section('content')
<div id="admin-info" class="well clearfix">
	<h4 class="group-title">Password Reset</h4>
	<hr class="title-hr">
	<span class="info-span" style="font-size:13px;">You recently request to reset your password. If you didn't request a password reset, <a href="">click here</a></span>
	{{ Form::open(array('action' => 'RemindersController@postReset', 'class'=>'','role'=>"form")) }}
	<div class="info-space form-group {{ $errors->has('email') ? 'has-error' : false }}">
		<label class="control-label" for="email">Email</label>
		{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'(ex: example@example.com) ')) }}
		@foreach($errors->get('email') as $message)
		<span class='help-block'>{{ $message }}</span>
		@endforeach
	</div>	
	<div class=" info-space form-group">
		<label class="control-label" for="Password">Password</label>
		<input name="password" class="form-control" id="Password"
		placeholder="Enter Password" type="password">
	</div>
	<div class=" info-space form-group">
		<label class="control-label" for="password_confirmation">Password Confirmation</label>
		<input name="password_confirmation" class="form-control" id="password_confirmation"
		placeholder="Re-Enter Password" type="password">
	</div>	
	<button type="submit" class="btn btn-primary pull-right">Reset Password</button>
	{{ Form::hidden('token',$reminder_token,['id'=>'reminder_token'])}}
	{{ Form::close() }}
</div>

<style>
.title-hr{
	margin-top: 10px;
	margin-bottom: 10px;
}
.group-title{
	margin-top: 25px;
}
.main-group-title{
	margin-top: 0px;
}
.info-space{
	margin-top: 10px;
}
</style>
@stop