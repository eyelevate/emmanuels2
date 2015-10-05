@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/pages_add.css')!!}
@stop
@section('scripts')
{!! Html::script('/packages/tinymce2/js/tinymce/tinymce.min.js') !!}
{!! Html::script('/packages/riverside-friendurl-e3d8b63/jquery.friendurl.js') !!}
{!! Html::script('/assets/js/pages_add.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Pages Add</h1>
	<ol class="breadcrumb">
		<li class="active">Pages Add</li>
		<li><a href="{!! action('PagesController@getIndex') !!}">Pages Overview</a></li>
	</ol>
</div>
{!! Form::open(array('action' => 'PagesController@postAdd', 'class'=>'','role'=>"form")) !!}

<div class="row">
	<div class="col-md-2" style="margin-bottom:5px;">
		<ul id="deliveryStepy" class="nav nav-pills nav-stacked">
			<li class="active " role="presentation"><a href="#marketing"><span class="badge">1</span> Marketing</a></li>
			<li class="content-step" role="presentation"><a href="#content"><span class="badge">2</span> Content</a></li>
		</ul>
	</div>
	<div class="col-md-10 pull-right">
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
				<label class="control-label" for="title">Title&nbsp;&nbsp;</label>
				{!! Form::text('title', isset($form_data['title'])?$form_data['title']:null, array('class'=>'form-control', 'placeholder'=>'Title','id'=>'title')) !!}
				<span class='help-block hide' id="title-duplicate">This is a protected title please choose another name</span>
				@foreach($errors->get('title') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			<div class="form-group {!! $errors->has('description') ? 'has-error' : false !!}">
				<label class="control-label" for="description">Description</label>
				{!! Form::textarea('description', isset($form_data['description'])?$form_data['description']:null, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Description')) !!}
				@foreach($errors->get('description') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			<div class="form-group {!! $errors->has('url') ? 'has-error' : false !!}">
				<label class="control-label" for="url">Url</label>
				{!! Form::text('url', isset($form_data['url'])?$form_data['url']:null, array('readonly'=>'readonly','class'=>'form-control','placeholder'=>'Url','id'=>'url')) !!}
				@foreach($errors->get('url') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
			<p id="page-info col-md-12">
				<i class="glyphicon glyphicon-info-sign"style="color:#5bc0de;"></i>&nbsp;This is your page URL
			</p>
			<div class="form-group {!! $errors->has('keywords') ? 'has-error' : false !!}">
				<label class="control-label" for="keywords">Keywords</label>
				{!! Form::textarea('keywords', isset($form_data['keywords'])?$form_data['keywords']:null, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Keywords')) !!}
				@foreach($errors->get('keywords') as $message)
				<span class='help-block'>{!! $message !!}</span>
				@endforeach
			</div>
		</div>
		<div class="panel-footer clearfix">
			<button type="button" class="btn btn-primary pull-right submit-btn next" >Next</button>
		</div>
	</div>
	<div id="content" class="steps panel panel-success hide">
		<div class="panel-heading" style="font-size:17px;"><strong>Content Management</strong></div>
		<div class="panel-body">
			<button type="button" id="add-content" class=" btn btn-success btn-block" >Add Section&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
			<div class="content-area">
				<div class="content-area-session  {!!isset($form_data['Html'])?'':'hide'!!}">
					@if(!empty($form_data['Html']))
					@foreach($form_data['Html'] as $data)
					{!!$data!!}
					@endforeach
					@endif
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
			<button type="submit" class="btn btn-primary pull-right submit-btn">Preview</button>
		</div>
	</div>
</div>
</div>
{!! Form::hidden('content_count',null,['id'=>'content_count']); !!}
{!! Form::close() !!}
@stop