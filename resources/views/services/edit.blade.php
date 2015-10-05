@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
<div class="jumbotron">
	<h1>Services Add</h1>
	<ol class="breadcrumb">
		<li class="active">Services edit</li>
		<li><a href="{{ action('ServicesController@getIndex') }}">Services Overview</a></li>
	</ol>
</div>
{{ Form::open(array('action' => 'ServicesController@postEdit', 'class'=>'','role'=>"form")) }}
<div  class="panel panel-success">
	<div class="panel-body">
		<div class="form-group {{ $errors->has('name') ? 'has-error' : false }}">
			<label class="control-label" for="name">Name</label>
			{{ Form::text('name', $services->name, array('class'=>'form-control', 'placeholder'=>'Name','id'=>'name')) }}
			@foreach($errors->get('name') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
			<label class="control-label" for="description">Description</label>
			{{ Form::textarea('description',$services->description, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Description')) }}
			@foreach($errors->get('description') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group {{ $errors->has('rate') ? 'has-error' : false }}">
			<label class="control-label" for="name">Rate</label>
			<div class="input-group">
				<input type="text" name="rate" value="{{$services->rate}}" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="00.0">
				<span class="input-group-addon">$</span>
			</div>
			@foreach($errors->get('rate') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group {{ $errors->has('type') ? 'has-error' : false }}">
			<label class="control-label" for="type">Type</label>
			{{ Form::select('type',$types,$services->type, ['id'=>'type','class'=>'form-control']) }}
			@foreach($errors->get('type') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" class="btn btn-primary pull-right">Save</button>
	</div>
</div>
{{ Form::hidden('id', $services->id) }}
{{Form::close()}}
@stop