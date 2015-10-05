@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

{!! Html::script('/assets/js/pages_edit_home.js') !!}
@stop

@section('content')



<div class="" style="padding-top:8px;min-height:600px;">
	{!!$content!!}
</div>
<div class="panel-footer" style="border: 1px solid rgb(231, 231, 231);">
	<a href="{!! action('PagesController@getEdit') !!}" class="previous btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
	<a href="{!! action('PagesController@getPreviewEdit') !!}" class="btn btn-primary pull-right">Save &nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-ok"></i></a>
</div>
@stop

