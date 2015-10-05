@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/pages_index.css') !!}
@stop
@section('scripts')
{!! Html::script('/assets/js/pages_index.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Pages</h1>
	<ol class="breadcrumb">
		<li class="active">Pages Overview</li>
		<li><a href="{!! action('PagesController@getAdd') !!}">Add Page</a></li>
		<li><a href="{!! action('MenusController@getAdd') !!}">Add Menu</a></li>
	</ol>
	@if(isset($pages))
	@if(count($pages) <= 1)
		<div class="alert alert-warning" role="alert">
			<h5 href="#" class="alert-link">To get started click on the (“Add Page”) button below to create you first page</h5>
			<a this-url="{!! action('PagesController@getAdd') !!}" id="page-add" class="alert-link btn btn-default" >
				<i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add Page
			</a>
			<button type="button" class="btn btn-primary reload-pages" ><i class="glyphicon glyphicon-refresh"></i>&nbsp;Reload</button> 
		</br>
	</div>
	@endif
	@endif
</div>
<div class="table-responsive">
	<table id="page_table" class="table table-striped table-bordered table-hover table-responsive {!!$count != 0?'':'hide'!!}" >
		<thead>
			<tr>
				<th>Id</th>
				<th>Company name</th>
				<th>Page Title</th>
				<th>Description</th>
				<th>Menu Groups</th>
				<th>Menu Items</th>
				<th>URL</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="page_table_body">
			@foreach($pages as $page)
			<tr>
				<td this-id="{!!$page->id!!}">{!! $page->id !!}</td>
				<td>{!! $page->company_name !!}</td>
				<td>{!! $page->title !!}</td>
				<td>{!! $page->description !!}</td>

				@if($page->id == 1)
				<td class="text-center">-</td>
				@else
				{!! $page->param_one_formated !!}
				@endif

				@if($page->id == 1)
				<td class="text-center">-</td>
				@else
				{!! $page->param_two_formated !!}
				@endif
		
				<td>{!! $page->url !!}</td>
				@if($page->id == 1)
				<td>-</td>
				@else
				<td>{!! Form::select('status', $prepared_status, $page->status, array('class'=>'form-control status status-'.$page->id,'not_empty'=>'true','status'=>false)); !!}</td>
				@endif
				<td><a href="{!! action('PagesController@getEdit',$page->id) !!}">Edit</a>
					{!! Form::open(array('action' => 'PagesController@postDelete', 'class'=>'remove-form','id'=>'form-'.$page->id,'role'=>"form",'files'=> true)) !!}
					{!! Form::hidden('page_id', $page->id) !!}
					@if($page->id != 1)
					/
					<a class="remove"  data-toggle="modal" data-target="#myModal" page-id="{!!$page->id!!}" count="{!!$page->item_count!!}">Remove</a></td>
					@endif
					{!! Form::close() !!}
				</td>

			</tr>

			@endforeach
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
	<div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header alert alert-warning">
					Warning!
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default no-status-btn" data-dismiss="modal">No</button>
					<button type="button" class="btn btn-danger yes-status-btn">Yes</button>
				</div>
			</div>
		</div>
	</div>
</div>

@stop