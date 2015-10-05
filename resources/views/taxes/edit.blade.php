@extends($layout)
@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Taxes Edit</h1>
		<ol class="breadcrumb">
			<li class="active">Taxes Edit</li>
			<li><a href="{!! action('TaxesController@getIndex') !!}">Taxes Overview</a></li>
		</ol>
	</div>
	
@stop