@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Delivery-rules</h1>
		<ol class="breadcrumb">
			<li class="active">Delivery-rules Overview</li>
			<li><a href="{{ action('DeliveryRulesController@getAdd') }}">Add an Inventory</a></li>
		</ol>
	</div>
	
@stop