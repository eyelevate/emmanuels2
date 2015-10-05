@extends($layout)
@section('stylesheets')

{!! Html::style('/packages/fileupload-9.8.0/css/jquery.fileupload.css') !!}
{!! Html::style('/packages/fileupload-9.8.0/css/jquery.fileupload-ui.css') !!}
{!! Html::style('/packages/Nestable-master/css.nestable.css') !!}
{!! Html::style('/packages/bootstrap-fileinput/css/fileinput.css')!!}
{!! Html::style('/assets/css/pages_edit.css')!!}

@stop
@section('scripts')

{!! Html::script('/packages/Nestable-master/jquery.nestable.js') !!}
{!! Html::script('/packages/tinymce2/js/tinymce/tinymce.min.js') !!}
{!! Html::script('/packages/riverside-friendurl-e3d8b63/jquery.friendurl.js') !!}
{!! Html::script('/packages/bootstrap-fileinput/js/fileinput.js') !!}
{!! Html::script('/assets/js/pages_edit.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Pages Edit</h1>
	<ol class="breadcrumb">
		<li class="active">Pages Edit</li>
		<li><a href="{!! action('PagesController@getIndex') !!}">Pages Overview</a></li>
	</ol>
</div>
{!! Form::open(array('action' => 'PagesController@postEdit', 'class'=>'','role'=>"form")) !!}
<div class="row">
	<div class="col-md-2" style="margin-bottom:5px;">
		<ul id="deliveryStepy" class="nav nav-pills nav-stacked">
			<li class="active " role="presentation"><a href="#marketing"><span class="badge">1</span> Marketing</a></li>
			<li class="content-step" role="presentation"><a href="#content"><span class="badge">2</span> Content</a></li>
			@if(isset($page_id))
			@if($page_id == 1)
			<li class="content-step" role="presentation"><a href="#slider"><span class="badge">3</span> Slider Image</a></li>
			@endif
			@endif
			@if(isset($form_data['page_id']))
			@if($form_data['page_id'] == 1)
			<li class="content-step" role="presentation"><a href="#slider"><span class="badge">3</span> Slider Image</a></li>
			@endif
			@endif

		</ul>
	</div>
	<div class="col-md-10">
		<div id="marketing" class="steps panel panel-success">
			<div class="panel-heading" style="font-size:17px;"><strong>Marketing</strong></div>
			<div class="panel-body">
				<div class="panel panel-default"  style="margin-top:10px;">
					<div class="panel-heading" id="acc-head" role="tab" id="headingOne" data-toggle="collapse"
					data-parent="#accordion" href="#accordion-pro" aria-expanded="true" aria-controls="collapseOne"
					style="cursor: pointer;">
					<h4 class="panel-title">
						<p>Protected Titles</p>
					</h4>
				</div>
				<div id="accordion-pro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						<?php
						$count = 1;
						?>
						@foreach($new_controller_names as $name)
						@if($name == "" || $name == "{param1}")
						@else
						<div id="labels-div" style="display:inline;font-size:20px"><span class="label label-default {!!$name!!}">{!!$name!!}</span></div>
						<?php
						$count++;
						?>
						@endif
						@endforeach
					</div>	
				</div>
			</div>
			<div class="form-group {!! $errors->has('title') ? 'has-error' : false !!}">
				<label class="control-label" for="title">Title</label>
				{!! Form::text('title', isset($form_data['title'])?$form_data['title']:$title, array('class'=>'form-control', 'placeholder'=>'Title','id'=>'title')) !!}
				<span class='help-block hide' id="title-duplicate">This is a protected title please choose another name</span>
				@foreach($errors->get('title') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			<div class="form-group {!! $errors->has('description') ? 'has-error' : false !!}">
				<label class="control-label" for="description">Description</label>
				{!! Form::textarea('description', isset($form_data['description'])?$form_data['description']:$description, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Description')) !!}
				@foreach($errors->get('description') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			@if(isset($url))
			@if($url == "/home")
			<?php 
			$url = "/";
			?>
			@endif
			@endif
			<div class="form-group {!! $errors->has('url') ? 'has-error' : false !!}">
				<label class="control-label" for="url">Url</label>
				{!! Form::text('url', isset($form_data['url'])?$form_data['url']:$url, array('readonly'=>'readonly','class'=>'form-control','readonly'=>'readonly','placeholder'=>'Url','id'=>'url')) !!}
				@foreach($errors->get('url') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			<div class="form-group {!! $errors->has('keywords') ? 'has-error' : false !!}">
				<label class="control-label" for="keywords">Keywords</label>
				{!! Form::textarea('keywords', isset($form_data['keywords'])?$form_data['keywords']:$keywords, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Keywords')) !!}
				@foreach($errors->get('keyword') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			@if(isset($form_data['page_id']))
			@if($form_data['page_id'] != 1)
			<div class="form-group {!! $errors->has('status') ? 'has-error' : false !!}">
				<label class="control-label" for="status">Status</label>
				{!! Form::select('status', $prepared_status, isset($form_data['status'])?$form_data['status']:$status, array('class'=>'form-control status','not_empty'=>'true','status'=>false)); !!}
				@foreach($errors->get('keyword') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			@endif
			@endif
			@if(isset($page_id))
			@if($page_id != 1)
			<div class="form-group {!! $errors->has('status') ? 'has-error' : false !!}">
				<label class="control-label" for="status">Status</label>
				{!! Form::select('status', $prepared_status, isset($form_data['status'])?$form_data['status']:$status, array('class'=>'form-control status','not_empty'=>'true','status'=>false)); !!}
				@foreach($errors->get('keyword') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			@endif
			@endif
		</div>
		<div class="panel-footer clearfix">
			<button type="button" class="btn btn-primary pull-right submit-btn next" >Next</button>
		</div>
	</div>
	<div id="content" class="steps panel panel-success hide">
		<div class="panel-heading" style="font-size:17px;"><h3>Content Management</h3></div>
		<div class="panel-body">
			<button type="button" id="add-content" class=" btn btn-success btn-block" >Add Section&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
			<div class="content-area">

				@if($content)
				@foreach($content as $data)
				@foreach($data as $collapse)
				{!!$collapse!!}
				@endforeach
				@endforeach
				@endif

				<div class="content-area-session  {!!isset($form_data['html'])?'':'hide'!!}">
					@if(!empty($form_data['html']))
					@foreach($form_data['html'] as $data)
					{!!$data!!}
					@endforeach
					@endif
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
			@if(isset($page_id))
			@if($page_id == 1)
			<button type="button" class="btn btn-primary pull-right submit-btn next" >Next</button>
			@else
			<button type="submit" class="btn btn-primary pull-right submit-btn">Preview</button>
			@endif
			@endif
			@if(isset($form_data['page_id']))
			@if($form_data['page_id'] == 1)
			<button type="button" class="btn btn-primary pull-right submit-btn next" >Next</button>
			@else
			<button type="submit" class="btn btn-primary pull-right submit-btn">Preview</button>
			@endif
			@endif
		</div>
	</div>
	<div id="slider" class="steps panel panel-success hide">
		<div class="panel-heading" style="font-size:17px;"><h3>Slider Image</h3></div>
		<div class="panel-body clearfix slider-body">
			<div id="sliderDiv" class="content-area-slider col-md-10 col-lg-10 pull-left">
				<div class="dd" id="nestable3" style="width: 100% !important">
					<ol class="dd-list">
						{!!$session_slider_images!!}
					</ol>
				</div>
			</div>
			<div class="row-fluid col-sm-2 col-lg-2 pull-right">
				<button id="addSlide" class="btn btn-md btn-primary" type="button">Add Slide <i class="glyphicon glyphicon-plus"></i></button>
			</div>

		</div>
		<div class="panel-footer">
			<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
			<button type="submit" class="btn btn-primary pull-right submit-btn">Preview</button>
		</div>
	</div>

</div>
</div>
{!! Form::hidden('page_id',isset($form_data['page_id'])?$form_data['page_id']:$page_id,['id'=>'page_id']); !!}
{!! Form::hidden('content_count',null,['id'=>'content_count']); !!}
{!! Form::hidden('key_down',"0",['id'=>'key_down']); !!}
{!! Form::hidden('is_session',$is_session,['id'=>'is_session']); !!}
{!! Form::close() !!}


@stop