@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
	<section class="section">
		@if(isset($home_content))
			@foreach ($home_content as $content)
				<h3>{!! $content->content_title!!}</h3>
				<p>{!! $content->content_body!!}</p>
			@endforeach
		@endif
	</section>
@stop