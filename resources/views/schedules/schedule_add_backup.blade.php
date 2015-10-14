@extends($layout)
@section('stylesheets')
@stop
@section('scripts')
<!-- DATEPICKER -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
{!! Html::script('/assets/js/schedules_add.js') !!}
@stop
@section('content')
<div class="jumbotron">
	<h1>Schedules Add</h1>
	<ol class="breadcrumb">
		<li class="active">Schedules Add</li>
		<li><a href="{!! action('SchedulesController@getIndex') !!}">Schedules Overview</a></li>
	</ol>
</div>
{!! Form::open(array('action' => 'SchedulesController@postPreview', 'class'=>'','id'=>'add-form','role'=>"form")) !!}
<div class="row" id="this-body"> 
	<div class="col-md-3" style="margin-bottom:5px;">
		<ul id="deliveryStepy" class="nav nav-pills nav-stacked">
			<li id="search-stepy" class="{!!isset($preview_data)?'':'active'!!}" role="presentation"><a href="#search"><span class="badge">1</span> User Search</a></li>
			<li id="user-info" class="{!!isset($preview_data)?'active':''!!}" role="presentation"><a href="#information"><span class="badge">2</span> User Information</a></li>
			<li id="order-step" class="content-step disabled" role="presentation"><a href="#content"><span class="badge">3</span> Order</a></li>
		</ul>
	</div>
	<div class="col-md-9 pull-right">
		<div id="search" class="steps panel panel-success {!!isset($preview_data)?'hide':''!!}">
			<div class="panel-heading" style="font-size:17px;"><strong>Search</strong></div>
			<div class="panel-body">
				<div id="customerMembers" class="">
					<div class="form-group">
						<label class="control-label" for="id">Find By:</label>
						{!! Form::select('search',$search_by ,'username', ['id'=>'searchBy','class'=>'form-control','status'=>false]) !!}
						@foreach($errors->get('id') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div id="searchBy-id" class="searchByFormGroup form-group {!! $errors->has('id') ? 'has-error' : false !!} well well-sm hide">
						<label class="control-label" for="id">User Id</label>
						<div class="input-group">
							{!! Form::text('id', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'user id','status'=>false)) !!}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('id') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>	
					<div id="searchBy-username" class="searchByFormGroup form-group {!! $errors->has('username') ? 'has-error' : false !!} well well-sm">
						<label class="control-label" for="email">Username</label>
						<div class="input-group">
							{!! Form::text('username', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'username','status'=>false)) !!}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('email') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>	
					<div id="searchBy-phone" class="searchByFormGroup clearfix well well-sm hide">	
						<label class="col-md-12">Phone Number</label>
						<div class="input-group" style="">

							{!! Form::text('phone', null, array('class'=>'form-control search-phone searchInputItem', 'placeholder'=>'eg ### ### ####')) !!}				    	
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
					</div> 
					<div id="searchBy-email" class="searchByFormGroup form-group {!! $errors->has('email') ? 'has-error' : false !!} well well-sm hide">
						<label class="control-label" for="email">Email</label>
						<div class="input-group">
							{!! Form::text('email', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'(ex: example@example.com)','status'=>false)) !!}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('email') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>	
					<div id="searchBy-name" class="searchByFormGroup well well-sm hide">
						<div class="form-group {!! $errors->has('firstname') ? 'has-error' : false !!}">
							<label class="control-label" for="firstname">First Name</label>
							{!! Form::text('first_name', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'First Name')) !!}
							@foreach($errors->get('firstname') as $message)
							<span class='help-block'>{!! $message !!}</span>
							@endforeach
						</div>	
						<div class="form-group {!! $errors->has('last_name') ? 'has-error' : false !!}">
							<label class="control-label" for="last_name">Last Name</label>
							{!! Form::text('last_name', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'Last Name')) !!}
							@foreach($errors->get('last_name') as $message)
							<span class='help-block'>{!! $message !!}</span>
							@endforeach
						</div>	
						<div class="form-group">
							<button type="button" class="searchByButton btn btn-info"><i class="glyphicon glyphicon-search"></i> Search</button>
						</div>			
					</div>
				</div>
			</div>
			<table id="userSearchTable" class="table table-hover hide" style="margin-bottom:20px;">
				<thead>
					<tr>
						<th>Id</th>
						<th>Username</th>
						<th>First</th>
						<th>Last</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<div class="panel-footer clearfix">
				<button type="button" id="first-next" class="btn btn-primary pull-right next" >Continue As Guest <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>
		<div id="information" class="steps panel panel-success {!!isset($preview_data)?'':'hide'!!}">
			<div class="panel-heading" style="font-size:17px;"><strong>User Information</strong></div>
			<div class="panel-body">
				<ul id="searchCustomerNavTabs" class="nav nav-tabs">
					<!-- ACTIVATING THE TABS AND CHECKING IF TE NEW ADDRESS WAS SET -->
					<li id="member-tab" class="
						@if(isset($preview_data['is_new']))
							@if($preview_data['is_new'] != true)
								active
							@endif
						@else
							active
						@endif
					" role="presentation" type="members"><a href="#address">Address</a></li>
					<li id="new-address-tab" class="
						@if(isset($preview_data['is_new']))
							@if($preview_data['is_new'] == true)
								active
							@endif
						@endif
					" role="presentation" type="guests"><a href="#newaddress">New Address</a></li>
				</ul>
				<br/>
				<!-- CHECK IF THE SESSION EXISTS FIRST, IF SO CHECK IF THE ENTERED ADDRESS IS NEW -->
				<div id="address" class="customerListDiv 
						@if(isset($preview_data['is_new']))
							@if($preview_data['is_new'] == true)
								hide
							@endif
						@endif
				 ">
				 	<h4 class="first-group-title">Type</h4>
					<hr class="title-hr">
					<div class="form-group">
						<div class="radio">
							<label>
								<!-- CHECKING THE SESSION -->
								<input type="radio" name="estimate_or_order" id="estimate" value="1"
									@if(isset($preview_data['estimate']))
										{!!$preview_data['estimate']!!}
									@endif
								>
								ESTIMATE
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="estimate_or_order" id="order" value="2" 
									@if(isset($preview_data['order']))
										{!!$preview_data['order']!!}
									@else
										checked
									@endif>
								WORK ORDER
							</label>
						</div>
					</div>
					<h4 class="group-title">Place</h4>
					<hr class="title-hr">
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="store_or_house" id="in-house" value="2" 
									@if(isset($preview_data['in_house']))
										{!!$preview_data['in_house']!!}
									@else
										checked
									@endif>
								In-House
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="radio">
							<label>
								<!-- CHECKING THE SESSION -->
								<input type="radio" name="store_or_house" id="in-store" value="1"
									@if(isset($preview_data['in_store']))
										{!!$preview_data['in_store']!!}
									@endif
								>
								In-Store
							</label>
						</div>
					</div>
					
					<h4 class="group-title">User Information</h4>
					<hr class="title-hr">
					<div class="form-group  {!! $errors->has('first_name') ? 'has-error' : false !!}">
						<label class="control-label" for="first_name">First Name&nbsp;&nbsp;</label>
						{!! Form::text('first_name', isset($preview_data['first_name'])?$preview_data['first_name']:null, array('class'=>'form-control', 'placeholder'=>'First Name','id'=>'first_name')) !!}
						  	<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
  							<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
							<span class='help-block val-help hide'></span>
						@foreach($errors->get('first_name') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group  {!! $errors->has('last_name') ? 'has-error' : false !!}">
						<label class="control-label" for="last_name">Last Name&nbsp;&nbsp;</label>
						{!! Form::text('last_name', isset($preview_data['last_name'])?$preview_data['last_name']:null, array('class'=>'form-control', 'placeholder'=>'Last Name','id'=>'last_name')) !!}
						  	<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
  							<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
							<span class='help-block val-help hide'></span>
						@foreach($errors->get('last_name') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('telephone') ? 'has-error' : false !!}">
						<label class="control-label" for="telephone">Telephone&nbsp;&nbsp;</label>
						{!! Form::text('telephone', isset($preview_data['phone'])?$preview_data['phone']:null, array('class'=>'form-control', 'placeholder'=>'Telephone','id'=>'telephone')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('telephone') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('email') ? 'has-error' : false !!}">
						<label class="control-label" for="email">Email&nbsp;&nbsp;</label>
						{!! Form::text('email', isset($preview_data['email'])?$preview_data['email']:null, array('class'=>'form-control', 'placeholder'=>'Email','id'=>'email')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('email') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('street') ? 'has-error' : false !!}">
						<label class="control-label" for="street">Street&nbsp;&nbsp;</label>
						{!! Form::text('street', isset($preview_data['street'])?$preview_data['street']:null, array('class'=>'form-control', 'placeholder'=>'Street','id'=>'street')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('street') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('unit') ? 'has-error' : false !!}">
						<label class="control-label" for="unit">Unit&nbsp;&nbsp;</label>
						{!! Form::text('unit', isset($preview_data['unit'])?$preview_data['unit']:null, array('class'=>'form-control', 'placeholder'=>'Unit','id'=>'unit')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('unit') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('city') ? 'has-error' : false !!}">
						<label class="control-label" for="city">City&nbsp;&nbsp;</label>
						{!! Form::text('city', isset($preview_data['city'])?$preview_data['city']:null, array('class'=>'form-control', 'placeholder'=>'City','id'=>'city')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>						
						@foreach($errors->get('city') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('state') ? 'has-error' : false !!}">
						<label class="control-label" for="state">State&nbsp;&nbsp;</label>
						{!! Form::text('state', isset($preview_data['state'])?$preview_data['state']:null, array('class'=>'form-control', 'placeholder'=>'State','id'=>'state')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('state') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('zipcode') ? 'has-error' : false !!}">
						<label class="control-label" for="zipcode">Zipcode&nbsp;&nbsp;</label>
						{!! Form::text('zipcode', isset($preview_data['zipcode'])?$preview_data['zipcode']:null, array('class'=>'form-control', 'placeholder'=>'Zipcode','id'=>'zipcode')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>						
						@foreach($errors->get('zipcode') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>

					<h4 class="group-title">Schedule dates</h4>
					<hr class="title-hr">
					<!-- PICK UP DATE -->
					<div class="form-group {!! $errors->has('zipcode') ? 'has-error' : false !!}">
						<label class="control-label" for="pick_up">PICK UP DATE&nbsp;&nbsp;</label>
						<div class="input-group pickup-content">
							<input type="text" value="{!!isset($preview_data['pickup_date'])?$preview_data['pickup_date']:null!!}" class="form-control  set-date " id="pickup-date" name="pickup_date" readonly="readonly" this-group="pickup" style="cursor:pointer;background-color:#fff"  placeholder="" aria-describedby="basic-addon2">
							<span class="input-group-addon calendar" style="cursor:pointer" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						<!-- PICKUP ERROR -->
						<span class="pickup-date-error help-block hide" style="color:#a94442;">Pick-Up date is required</span>
					</div>

					<!-- DELIVERY DATE -->
					<div class="form-group {!! $errors->has('zipcode') ? 'has-error' : false !!}">
						<label class="control-label" for="delivery">DELIVERY DATE&nbsp;&nbsp;</label>
						<div class="input-group delivery-content">
							<input type="text" value="{!!isset($preview_data['delivery_date'])?$preview_data['delivery_date']:null!!}" class="form-control set-date" id="delivery-date" readonly="readonly" name="delivery_date" this-group="delivery" style="cursor:pointer;background-color:#fff"  placeholder="" aria-describedby="basic-addon2">
							<span class="input-group-addon calendar" style="cursor:pointer" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						<!-- DELIVERY ERROR -->
						<span class="delivery-date-error help-block hide" style="color:#a94442;">Delivery date is required</span>
					</div>

					<div class="form-group {!! $errors->has('will_phone') ? 'has-error' : false !!}">
						<div class="checkbox">
							<label>
								<!-- IF IS SESSION SET WILL_PHONE -->
								<input type="checkbox" value="1" name="will_phone" 
									@if(isset($preview_data['will_phone']))
										{!!$preview_data['will_phone']!!}
									@endif
								>
								WILL PHONE
							</label>
						</div>
					</div>
				</div><!-- Addess END -->
				<div id="newaddress" class="customerListDiv 
					@if(isset($preview_data['is_new']))
						@if($preview_data['is_new'] == true)
						@else
							hide
						@endif
					@else
						hide
					@endif
				">
					<!-- new address error -->
					<span class="new-address-error help-block hide" style="color:#a94442;">Entered address is incomplete. Please fill the information below.</br> If you do not wish to add a new address <a class="btn btn-primary" id="no-new"> Click here</a></span>
					<div class="alert alert-danger hide" id="alert-forgotten" role="alert">Name, Phone and Email are required. Click <a class="btn btn-primary" id="set-forgotten-btn">here</a> to set the required fields.</div>
					<div class="form-group {!! $errors->has('new_street') ? 'has-error' : false !!}">
						<label class="control-label" for="new_street">Street&nbsp;&nbsp;</label>
						{!! Form::text('new_street', isset($preview_data)?$preview_data['new_street']:null, array('class'=>'form-control', 'placeholder'=>'Street','id'=>'new_street')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('new_street') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('new_unit') ? 'has-error' : false !!}">
						<label class="control-label" for="new_unit">Unit&nbsp;&nbsp;</label>
						{!! Form::text('new_unit', isset($preview_data)?$preview_data['new_unit']:null, array('class'=>'form-control', 'placeholder'=>'Unit','id'=>'new_unit')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('new_unit') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('new_city') ? 'has-error' : false !!}">
						<label class="control-label" for="new_city">City&nbsp;&nbsp;</label>
						{!! Form::text('new_city', isset($preview_data)?$preview_data['new_city']:null, array('class'=>'form-control', 'placeholder'=>'City','id'=>'new_city')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('new_city') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('new_state') ? 'has-error' : false !!}">
						<label class="control-label" for="new_state">State&nbsp;&nbsp;</label>
						{!! Form::text('new_state', isset($preview_data)?$preview_data['new_state']:null, array('class'=>'form-control', 'placeholder'=>'State','id'=>'new_state')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('new_state') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('new_zipcode') ? 'has-error' : false !!}">
						<label class="control-label" for="new_zipcode">Zipcode&nbsp;&nbsp;</label>
						{!! Form::text('new_zipcode', isset($preview_data)?$preview_data['new_zipcode']:null, array('class'=>'form-control', 'placeholder'=>'Zipcode','id'=>'new_zipcode')) !!}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('new_zipcode') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
				</div>
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="1"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="button" id="next-btn" class="btn btn-primary pull-right next

				 disabled

				 " >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>
		<div id="content" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>Content Management</strong></div>
			<div class="panel-body">
				<button type="button" id="add-content" class=" btn btn-success btn-block" >Add Order&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
				
				<span class="empty-order-error help-block hide" style="color:#a94442;">Nothing to preview. In order to continue please add an order</span>

				<div class="content-area">
					@if(isset($orders_html))
						{!!$orders_html!!}
					@endif
				</div>
			</div>
			<div class="panel-footer">
				<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="button" class="btn btn-primary pull-right submit-btn">Preview</button>
			</div>
		</div>
	</div>
</div>
{!! Form::hidden('content_count',null,['id'=>'content_count'])!!}
{!! Form::hidden('user_id',null,['id'=>'user_id'])!!}
{!! Form::hidden('checklist', null,array('id'=>'checklist')) !!}
{!! Form::hidden('tabs_checklist', "address",array('id'=>'tabs_checklist')) !!}

<!-- ASSIGNING NEW VARIABLE -->
{{--*/ $session_ind = false /*--}}
{{--*/ $isset_new_address = false /*--}}
{{--*/ $count_orders = 0 /*--}}
@if(isset($preview_data))
		{{--*/ $session_ind = true /*--}}
	@if($preview_data['is_new'] == true)
		{{--*/ $isset_new_address = true /*--}}
	@endif
@endif
@if(isset($preview_data))
	{{--*/ $count_orders = $preview_data['count_all'] /*--}}
@endif
{!! Form::hidden('isset_session', $session_ind,array('id'=>'isset_session')) !!}
{!! Form::hidden('isset_new_address', $isset_new_address,array('id'=>'isset_new_address')) !!}
{!! Form::hidden('service_count', $count_orders,array('id'=>'service_count')) !!}

{!! Form::close() !!}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				Loading &nbsp;&nbsp; <img src="/assets/img/gif/ajax-loader.gif">
			</div>
		</div>
	</div>
</div>
<style>
.title-hr{
margin-top: 10px;
margin-bottom: 10px;
}
.group-title{
margin-top: 25px;
}
.first-group-title{
margin-top: 0px;
}
</style>
@stop