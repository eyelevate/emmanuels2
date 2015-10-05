@section('stylesheets')

@stop

@section('content')
<div id="admin-info" class="well clearfix">
		<h4 class="group-title">Couldn't Access Your Account?</h4>
		<hr class="title-hr">
		<span class="info-span" style="font-size:13px;">Enter your email address bellow and we will send you an email with a link to reset your password.</span>
		{{ Form::open(array('action' => 'RemindersController@postForgot', 'class'=>'','role'=>"form")) }}
		<div class="info-space form-group {{ $errors->has('email') ? 'has-error' : false }}">
			<label class="control-label" for="email">Email</label>
			{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'(ex: example@example.com) ')) }}
			@foreach($errors->get('email') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>	
	<button type="submit" class="btn btn-primary pull-right">Submit</button>
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