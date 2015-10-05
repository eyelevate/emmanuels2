@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Inventory-Items Edit</h1>
		<ol class="breadcrumb">
			<li class="active">Inventory-Items Edit</li>
			<li><a href="{{ action('InventoryItemsController@getIndex') }}">Inventory-Items Overview</a></li>
		</ol>
	</div>
	{{ Form::open(array('action' => 'InventoryItemsController@postEdit', 'class'=>'','role'=>"form")) }}
<div  class="panel panel-success">
	<div class="panel-body">
		
		<div class="form-group {{ $errors->has('inventory_id') ? 'has-error' : false }}">
			<label class="control-label" for="inventory_id">Inventory</label>
			{{ Form::select('inventory_id',$inventories ,$inventory_items->inventory_id, ['id'=>'inventory_id','class'=>'form-control']) }}
			@foreach($errors->get('inventory_id') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>

		<div class="form-group {{ $errors->has('name') ? 'has-error' : false }}">
			<label class="control-label" for="name">Name</label>
			{{ Form::text('name', $inventory_items->name, array('class'=>'form-control', 'placeholder'=>'Name','id'=>'name')) }}
			@foreach($errors->get('name') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
			<label class="control-label" for="description">Description</label>
			{{ Form::textarea('description',$inventory_items->description, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Description')) }}
			@foreach($errors->get('description') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group {{ $errors->has('price') ? 'has-error' : false }}">
			<label class="control-label" for="name">Price</label>
			<div class="input-group">
				<input type="text" name="price" value="{{$inventory_items->price}}" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="00.0">
				<span class="input-group-addon">$</span>
			</div>
			@foreach($errors->get('price') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" class="btn btn-primary pull-right">Save</button>
	</div>
</div>
{{ Form::hidden('id', $inventory_items->id) }}
{{Form::close()}}
@stop