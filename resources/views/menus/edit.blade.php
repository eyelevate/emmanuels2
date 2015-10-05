@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/menus_add.css') !!}
@stop
@section('scripts')
{!! Html::script('/packages/riverside-friendurl-e3d8b63/jquery.friendurl.js') !!}
{!! Html::script('/assets/js/menus_edit.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Menus Edit</h1>
	<ol class="breadcrumb">
		<li class="active">Menus Edit</li>
		<li><a href="{!! action('MenusController@getIndex') !!}">Menus Overview</a></li>
	</ol>
</div>
{!! Form::open(array('action' => 'MenusController@postEdit', 'class'=>'','role'=>"form")) !!}
<div  class="panel panel-success">
	<div class="panel-body">
		<div class="form-group {!! $errors->has('name') ? 'has-error' : false !!}">
			<label class="control-label" for="name">Display Title</label>
			{!! Form::text('name', $menus->name, array('class'=>'form-control', 'placeholder'=>'Display Title','id'=>'name')) !!}
			@foreach($errors->get('name') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
		<div class="form-group {!! $errors->has('kind') ? 'has-error' : false !!}">
			<label class="control-label" for="kind">Type</label>
			{!! Form::select('kind', $prepared_select, $is_link, array('class'=>'form-control kind','not_empty'=>'true','kind'=>false)); !!}
			@foreach($errors->get('keyword') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
		<div class="col-md-12 clearfix clear-padding hide-link">
			<label class="control-label col-md-12 col-xs-12 clear-padding" for="page_id">Page</label>
			<div class="col-md-10 col-lg-10 col-xs-7 clear-padding">
				<div class="form-group page-field {!! $errors->has('page_id') ? 'has-error' : false !!}" style="margin-bottom: 10px;">
					
					{!! Form::select('page_id', $pages_prepared, isset($menu_page_id)?$menu_page_id:null, array('class'=>'form-control page_id','not_empty'=>'true','page_id'=>false)); !!}
					@foreach($errors->get('page_id') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach
				</div>
			</div>
			<div class="col-md-2 col-lg-2 col-xs-5 clear-right-padding">
				<button type="button" class="btn btn-primary btn-block" id="reload-pages-select">
						<i class="glyphicon glyphicon-refresh loading-icon"></i>
					
					<img class="hide" src="/img/icons/ajax-loader-2.gif" id="loading-gif" alt="loading" height="15" width="15">
					
					&nbsp;Reload Pages</button> 
			</div>
		</div>


		
		<div class="col-md-12 hide-link">
			<p id="page-info col-md-12">
				<i class="glyphicon glyphicon-info-sign"style="color:#5bc0de;"></i>&nbsp;In order to display your created page, you must set your page status
				to public. Please change statuses <i class="btn btn-sm btn-success" id="page-index" this-url="{!! action('PagesController@getIndex') !!}" href="#">Pages</i> here.
			</p>
		</div>
		
		<div class="col-md-12 hide-link clear-padding form-group {!! $errors->has('url') ? 'has-error' : false !!}">
			<label class="control-label" for="url">URL</label>
			{!! Form::text('url', isset($form_data['url'])?$form_data['url']:null, array('readonly'=>'readonly' ,'class'=>'form-control','placeholder'=>'Page URL','id'=>'url')) !!}
			@foreach($errors->get('url') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>
		<div class="col-md-12 hide-link">
			<p id="page-info col-md-12">
				<i class="glyphicon glyphicon-info-sign"style="color:#5bc0de;"></i>&nbsp;This is your page URL
			</p>
		</div>
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" class="btn btn-primary pull-right">Update</button>
	</div>
</div>
{!! Form::hidden('menu_id',$menu_id,['id'=>'menu_id']); !!}
{!! Form::hidden('is_link',$is_link,['id'=>'is_link']); !!}
{!!Form::close()!!}
@stop