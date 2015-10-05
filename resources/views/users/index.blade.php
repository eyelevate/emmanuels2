@extends($layout)
@section('stylesheets')
{!! Html::style('packages/DataTables-Bootstrap3/BS3/assets/css/datatables.css') !!}
{!! Html::style('/assets/css/user_index.css') !!}
@stop
@section('scripts')
{!! Html::script('/assets/js/users_index.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Users</h1>
	<ol class="breadcrumb">
		<li class="active">Users Overview</li>
		<li><a href="{!! action('UsersController@getAdd') !!}">Add User</a></li>
	</ol>
</div>

<div class="table-responsive">
	<table id="user_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Username</th>
				<th>Name</th>
				<th>Email</th>
				<th>Role</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="user_table_body">
			@foreach($users as $user)
			<tr> 
				<td>{!! $user->id !!}</td>
				<td>{!! $user->username !!}</td>
				<td>{!! $user->firstname !!} {!!$user->lastname!!}</td>
				<td>{!! $user->email !!}</td>
				<td>{!! $user->roles_formated !!}</td>
				<td><a href="{!! action('UsersController@getEdit',$user->id) !!}">Edit</a>
					@if($user_id != $user->id)
						{!! Form::open(array('action' => 'UsersController@postDelete', 'class'=>'remove-form','id'=>'form-'.$user->id,'role'=>"form",'files'=> true)) !!}
						{!! Form::hidden('user_id', $user->id) !!}
						<a class="remove" data-toggle="modal" data-target="#myModal"  user-id="{!!$user->id!!}" >/ Remove</a></td>
						{!! Form::close() !!}</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header alert alert-warning">
						Warning!
					</div>
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-danger remove-btn">Remove</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
@stop