@extends($layout)
@section('stylesheets')
	<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	{!! Html::style('/packages/fileupload-9.8.0/css/jquery.fileupload.css') !!}
	{!! Html::style('/packages/fileupload-9.8.0/css/jquery.fileupload-ui.css') !!}
	<!-- CSS adjustments for browsers with JavaScript disabled -->
	<noscript>{!! Html::style('/packages/fileupload-9.8.0/css/jquery.fileupload-noscript.css') !!}</noscript>
	<noscript>{!! Html::style('/packages/fileupload-9.8.0/css/jquery.fileupload-ui-noscript.css') !!}</noscript/>
	{!! Html::style('/packages/magnific/dist/magnific-popup.css') !!}
@stop
@section('scripts')
	{!! Html::script('/packages/fileupload-9.8.0/js/vendor/jquery.ui.widget.js') !!}
	{!! Html::script('/packages/blueimp-templates/js/tmpl.min.js') !!}
	{!! Html::script('/packages/blueimp-loadimage/js/load-image.all.min.js') !!}
	{!! Html::script('/packages/blueimp-canvastoblob/js/canvas-to-blob.min.js') !!}
	{!! Html::script('/packages/blueimp-gallery/js/jquery.blueimp-gallery.min.js') !!}
	{!! Html::script('/packages/fileupload-9.8.0/js/jquery.iframe-transport.js') !!}
	{!! Html::script('/packages/fileupload-9.8.0/js/jquery.fileupload.js') !!}
	{!! Html::script('/packages/fileupload-9.8.0/js/jquery.fileupload-process.js') !!}
	{!! Html::script('/packages/fileupload-9.8.0/js/jquery.fileupload-image.js') !!}
	{!! Html::script('/packages/fileupload-9.8.0/js/jquery.fileupload-audio.js') !!}
	{!! Html::script('/packages/fileupload-9.8.0/js/jquery.fileupload-video.js') !!}
	{!! Html::script('/packages/fileupload-9.8.0/js/jquery.fileupload-validate.js') !!}
	{!! Html::script('/packages/fileupload-9.8.0/js/jquery.fileupload-ui.js') !!}
	{!! Html::script('/packages/magnific/dist/jquery.magnific-popup.min.js') !!}
	{!! Html::script('/packages/lazy/lazyload.min.js') !!}
	
	{!! Html::script('/assets/js/resource_manage.js') !!}
@stop
@section('templates')
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
@stop
@section('sidebar')
<div class="nav nav-stacked hide list-group" id="sidebar-inner">
	<a href="#top" class="list-group-item">Top of page</a>
	<a href="#step1" class="list-group-item">Resource Upload</a>
	<a href="#step2" class="list-group-item">Resource Manage</a>

</div>    
@stop
@section('content')
	<div id="top" class="jumbotron">
		<h1>Resources</h1>
		<ol class="breadcrumb">
			<li class="active">Manage Resources</li>
		</ol>
	</div>

	{!! Form::open(array('action' => 'ResourcesController@postEdit', 'id'=>'fileupload','role'=>"form",'files'=> true)) !!}

	<div id="step1" class="panel panel-default">
		
		<div class="panel-heading">
			<h4>Resource Upload <span class="glyphicon glyphicon-info-sign"></span></h4>
		</div>
        <!-- The global progress state -->
        <div class="col-lg-5 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
		<div id="step1_panel" class="panel-body">

			<!-- The table listing the files available for upload/download -->
	        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
		</div>
		<div class="panel-footer">
			<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
	        <div class="row fileupload-buttonbar">
	            <div class="col-lg-7">
	                <!-- The fileinput-button span is used to style the file input field as button -->
	                <span class="btn btn-success fileinput-button">
	                    <i class="glyphicon glyphicon-plus"></i>
	                    <span>Add files...</span>
	                    <input type="file" name="files[]" multiple>
	                </span>
	                <button type="submit" class="btn btn-primary start">
	                    <i class="glyphicon glyphicon-upload"></i>
	                    <span>Start upload</span>
	                </button>
	                <button type="reset" class="btn btn-warning cancel">
	                    <i class="glyphicon glyphicon-ban-circle"></i>
	                    <span>Cancel upload</span>
	                </button>
	                <button type="button" class="btn btn-danger delete">
	                    <i class="glyphicon glyphicon-trash"></i>
	                    <span>Delete</span>
	                </button>
	                <input type="checkbox" class="toggle">
	                <!-- The global file processing state -->
	                <span class="fileupload-process"></span>
	            </div>
	        </div>
    	</div>
	</div>
	{!! Form::close() !!}
	<div id="step2" class="panel panel-default">
		
		<div class="panel-heading">
			<h4>Resource Manage <a href="{!! action('ResourcesController@getEdit',$companies['id']) !!}" type="button" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> refresh images</a></h4>
		</div>
		<div id="step1_panel" class="panel-body">
		@if(isset($resources))
			<?php $idx = 0; ?>
			@foreach($resources as $key => $value)
			<?php
			$idx++;
			$img = pathinfo('/'.$value);
			$img_base = $img['basename'];
			list($width, $height) = @getimagesize($value);
			?>
			<div class="row-fluid">
				<div class="col-sm-4 col-md-3" >
					<div class="thumbnail" style="height:300px;">
						@if($idx < 5)
						<img src="/{!! $value !!}" alt="..." style="min-height:75px; max-height:150px; min-width:75px; max-width:250px;">
						@else
						<img class="lazy" data-original="/{!! $value !!}" alt="..." style="min-height:75px; max-height:150px; min-width:75px; max-width:250px;">
						@endif
						
						<div class="caption">
							<h5>{!! $img_base !!}</h5>
							<p>w:{!! $width !!}px  h:{!! $height !!}px</p>
							<p>
								<a class="popup-link btn btn-default" href="/{!! $value !!}"><i class="glyphicon glyphicon-picture"></i></a>
								<a href="/{!! $value !!}" target="_blank" class="btn btn-info" role="button"><span class="glyphicon glyphicon-new-window"></span></a> 
								<a data-src="{!! $value !!}" class="deleteImage btn btn-danger" role="button"><span class="glyphicon glyphicon-trash"></span></a>
							</p>
						</div>
					</div>
				</div>
			</div>			
			@endforeach
		@endif
		</div>
	</div>

@stop
