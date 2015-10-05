@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Schedule-Rules</h1>
		<ol class="breadcrumb">
			<li class="active">Schedule-Rules Overview</li>
			<li><a href="{{ action('ScheduleRulesController@getAdd') }}">Add Rules</a></li>
		</ol>
	</div>
	
@stop