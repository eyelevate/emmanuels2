@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/pages.css')!!}
@stop
@section('scripts')

{!! Html::script('/assets/js/pages_js.js') !!}
@stop
@section('content')
<div class="page-content" style="padding-top:8px;min-height:600px;">
	@if(isset($page_content))
	@if(isset($title))

		@if($title == "contact")

		<div class="row">
			<div id="map-outer" class="col-xs-12 col-md-12">
				<div id="info_contact" class="col-md-6">
						@foreach ($page_content as $content)
						<h3>{!! $content->content_title!!}</h3>
						<p>{!! $content->content_body!!}</p>
						@endforeach
				</div>
				<div id="map-canvas" class=" img-thumbnail col-xs-12 col-md-6"></div>
			</div><!-- /map-outer -->
		</div> <!-- /row -->
		@else
			@foreach ($page_content as $content)
			<h3>{!! $content->content_title!!}</h3>
			<p>{!! $content->content_body!!}</p>
			@endforeach
		@endif
	@endif
	@endif
</div>
@stop