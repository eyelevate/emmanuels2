@extends($layout)
@section('stylesheets')
{!! Html::style('/packages/DataTables-Bootstrap3/BS3/assets/css/datatables.css') !!}
{!! Html::style('/assets/css/menu_Index.css') !!}
@stop
@section('scripts')
{!! Html::script('/assets/js/menus_index.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Menus</h1>
	<ol class="breadcrumb">
		<li class="active">Menus Overview</li>
		<li><a href="{!! action('MenusController@getAdd') !!}">Add Menu</a></li>
		<li><a href="{!! action('MenusController@getOrder') !!}">Menu Order</a></li>
		</br>
		<li><a href="{!! action('MenuItemsController@getIndex') !!}">/ Menu Items</a></li>
	</ol>

		@if(isset($menus))
		@if(count($menus) <= 1)
		<div class="alert alert-warning" role="alert">
			<h5 href="#" class="alert-link">To get started click on the (“Add Menu”) button below to create you first menu</h5>
			<a href="{!! action('MenusController@getAdd') !!}" class="alert-link btn btn-default" ><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add Menu</a>
			<button type="button" class="btn btn-primary reload-pages" ><i class="glyphicon glyphicon-refresh"></i>&nbsp;Reload</button> 
		</div>
		@endif
		@endif
</div>

<div class="table-responsive">
	<table id="menu_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Display Title</th>
				<th>Type</th>
				<th>Page</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="menu_table_body">
			@if(isset($menus))
			@foreach($menus as $menu)
			<tr> 
				<td>{!! $menu->id !!}</td>
				<td>{!! $menu->name !!}</td>
				<td>{!! $menu->kind !!}</td>
				<td>{!! $menu->page_title !!}</td>
				<td>{!! $menu->status_html !!}</td>
				<td>

				@if($menu->id != 1)
					<a href="{!! action('MenusController@getEdit',$menu->id) !!}">Edit</a>
					{!! Form::open(array('action' => 'MenusController@postDelete', 'class'=>'remove-form','id'=>'form-'.$menu->id,'role'=>"form",'files'=> true)) !!}
					{!! Form::hidden('menu_id', $menu->id) !!}
					<a class="remove"  menu-id="{!!$menu->id!!}" >/ Remove</a>
					{!! Form::close() !!}
					@if(!isset($menu->page_id))
					<a class="add-item"  menu-id="{!!$menu->id!!}" href="{!! action('MenuItemsController@getAdd',$menu->id) !!}" >/ Add Menu-Item</a>
					@endif
				@else
					-
				@endif

				</td>
					
				</tr>
				@endforeach
			@endif
			</tbody>
		</table>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header alert alert-warning">
						Warning!
					</div>
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-danger remove-btn">Remove</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	@stop