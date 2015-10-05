@extends($layout)
@section('stylesheets')
{!! Html::style('/packages/Nestable-master/css.nestable.css') !!}
@stop
@section('scripts')
{!! Html::script('/packages/Nestable-master/jquery.nestable.js') !!}
{!! Html::script('/assets/js/menus_order.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Pages Order</h1>
	<ol class="breadcrumb">
		<li class="active">Pages Order</li>
		<li><a href="{!! action('MenusController@getIndex') !!}">Menus Overview</a></li>
	</ol>
</div>
{!! Form::open(array('action' => 'MenusController@postOrder', 'class'=>'','role'=>"form")) !!}
<div  class="panel panel-success">
	<div class="panel-body">
		{!!$list_html!!}
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" class="btn btn-primary pull-right">Save</button>
	</div>
</div>
{!!Form::close()!!}
@stop