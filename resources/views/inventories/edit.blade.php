@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Inventories Edit</h1>
		<ol class="breadcrumb">
			<li class="active">Inventories Edit</li>
			<li><a href="{{ action('InventoriesController@getIndex') }}">Inventories Overview</a></li>
		</ol>
	</div>
	{{ Form::open(array('action' => 'InventoriesController@postEdit', 'class'=>'','role'=>"form")) }}
<div  class="panel panel-success">
	<div class="panel-body">
		<div class="form-group {{ $errors->has('name') ? 'has-error' : false }}">
			<label class="control-label" for="name">Name</label>
			{{ Form::text('name', $inventory->name, array('class'=>'form-control', 'placeholder'=>'Name','id'=>'name')) }}
			@foreach($errors->get('name') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
			<label class="control-label" for="description">Description</label>
			{{ Form::textarea('description',$inventory->description, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Description')) }}
			@foreach($errors->get('description') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" class="btn btn-primary pull-right">Update</button>
	</div>
</div>
{{ Form::hidden('id', $inventory->id) }}
{{Form::close()}}
@stop