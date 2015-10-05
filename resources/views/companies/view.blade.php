@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

	{!! Html::script('packages/numeric/jquery.numeric.js') !!}
	{!! Html::script('js/company_view.js') !!}
@stop
@section('sidebar')
<div class="nav nav-stacked hide list-group" id="sidebar-inner">
	<a href="#top" class="list-group-item scrollto">Top of page</a>
	<a href="#owner-info" class="list-group-item scrollto">Owner Info</a>
	<a href="#company-info" class="list-group-item scrollto">Company Info</a>
	<a href="#menu-info" class="list-group-item scrollto">Menu Info</a>
	<a href="#website-info" class="list-group-item scrollto">Website Info</a>
	<a href="#payment-info" class="list-group-item">Payment Info</a>
</div>    
@stop
@section('content')
<div id="top" class="jumbotron">
	<h1>Company Overview</h1>
	<p><samp>{!! $companies->name !!} <small>({!! $companies->nick_name !!})</small></samp></p>
	<ol class="breadcrumb">
		<li><a href="#owner-info">Owner Info</a></li>
		<li><a href="#company-info">Company Info</a></li>
		<li><a href="#menu-info">Menu Info</a></li>
		<li><a href="#website-info">Website Info</a></li>
		<li><a href="#payment-info">Payment Info</a></li>
	</ol>
</div>

<div data-spy="scroll" data-target="#navbar-1" data-offset="0" class="scrollspy">
	<div id="owner-info" class="panel panel-default">
		<div class="panel-heading"><h3 style="margin-top:10px;">Owner Information</h3></div>
		<ol class="breadcrumb" style="border-radius:0">
		  	<li class="active">Owner home</li>
		  	<li><a href="{!! action('UsersController@getEdit',$owners->id)!!}">Edit Owner</a></li>
		</ol>
		<div class="panel-body">
		
	

			<div class="form-horizontal">
				<div class="form-group">
					<label for="username" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
						<p class="form-control-static"><samp>{!! $owners->username !!}</samp></p>
					</div>
				</div>
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="firstname" class="col-sm-2 control-label">First Name</label>
					<div class="col-sm-10">
						<p class="form-control-static"><samp>{!! $owners->firstname !!}</samp></p>
					</div>
				</div>
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="lastname" class="col-sm-2 control-label">Last Name</label>
					<div class="col-sm-10">
						<p class="form-control-static"><samp>{!! $owners->lastname !!}</samp></p>
					</div>
				</div>
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="phone" class="col-sm-2 control-label">Phone Number</label>
					<div class="col-sm-10">
						<p class="form-control-static"><samp>{!! $owners->phone !!}</samp></p>
					</div>
				</div>
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email Address</label>
					<div class="col-sm-10">
						<p class="form-control-static"><samp>{!! $owners->email !!}</samp></p>
					</div>
				</div>
			</div>

		</div>
		<div class="panel-footer">
	  		<a href="{!! action('UsersController@getEdit',$owners->id)!!}" class="btn btn-primary">Edit Owner</a>
	  	</div>
	</div>
	
	<div id="company-info" class="panel panel-default">
		<div class="panel-heading"><h3 style="margin-top:10px;">Company Information</h3></div>
		<ol class="breadcrumb" style="border-radius:0">
		  <li class="active">View Company</li>
		  <li><a href="/companies/edit/{!! $companies['id'] !!}">Edit Company</a></li>
		</ol>
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="company_address" class="col-sm-2 control-label">Company Address</label>
					<div class="col-sm-10">
						<p class="form-control-static">
							<address>
								{!! $companies->street !!} 
								<br/>
								@if(isset($companies->state))
								{!! $companies->city.', '.$companies->state.' '.$companies->zipcode !!}
								@else
								{!! $companies->city.', '.$companies->region.' '.$companies->zipcode !!}
								@endif
								<br/>
								<abbr title="Phone">P:</abbr> {!! $companies->phone !!}
							</address>
						</p>
					</div>
				</div>
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="company_hours" class="col-sm-2 control-label">Company Hours</label>
					<div class="col-sm-10">
						<p class="form-control-static">
				    	@if(!empty($companies['store_hours']))
				    		<table class="table table-bordered table-condensed">
				    			<thead>
				    				<tr>
				    					<th>Day</th>
				    					<th>Hours</th>
				    				</tr>
				    			</thead>
				    			<tbody>
				    			@foreach ($companies['store_hours'] as $key => $value)
				    			<tr>
				    				<td>{!! $key !!}</td>
				    				@if($value['status'] == 'open')
				    				<td>{!! $value['open'].' - '.$value['close'] !!}</td>
				    				@else
				    				<td>Closed</td>
				    				@endif
				    			</tr>
				    			@endforeach
				    			</tbody>
				    		</table>
				    	@else
				    	<span class="label label-danger">Store hours not set</span>
				    	@endif
						</p>
					</div>
				</div>
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="company_email" class="col-sm-2 control-label">Company Email</label>
					<div class="col-sm-10">
						<p class="form-control-static"><a href="mailto:#">{!! $companies['email'] !!}</a></p>
					</div>
				</div>
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="company_email" class="col-sm-2 control-label">Company Status</label>
					<div class="col-sm-10">
						<p class="form-control-static">
					    	@if($companies['status'] == 1)
					    	<span class="label label-success">Active</span>
					    	@else
					    	<span class="label label-danger">Not Active</span>
					    	@endif
						</p>
					</div>
				</div>
			</div>
		</div>
	  	<div class="panel-footer">
	  		<a href="{!! route('companies_edit',$companies['id']) !!}" class="btn btn-primary">Edit Company Info</a>
	  	</div>
		
  	</div>		
  	<div id="menu-info" class="panel panel-default">
		<div class="panel-heading"><h3 style="margin-top:10px;">Menu Information</h3></div>
		<ol class="breadcrumb" style="border-radius:0; margin:0px;">
		  	<li><a href="{!!action('MenusController@getIndex')!!}">Menu Groups Edit</a></li>
		  	<li><a href="{!!action('MenuItemsController@getIndex')!!}">Menu Items Edit</a></li>
		</ol>
		<ul class="list-group">
			@if(isset($menus))
				@foreach($menus as $menu)
				<li class="list-group-item">
					<legend class="list-group-item-heading heading">{!! $menu['name'] !!} <small><a class="btn btn-link" href=""><i class="glyphicon glyphicon-pencil"></i></a></small></legend>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead style="background-color:#e5e5e5;">
								<tr>
									<th>id</th>
									<th>order</th>
									<th>name</th>
									<th>desc</th>
									<th>price</th>
									<th>imgs</th>
									<th>status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@if(isset($menu['menu_items']))
								@foreach($menu['menu_items'] as $items)
								<tr>
									<td>{!! $items['id'] !!}</td>
									<td>{!! $items['order_number'] !!}</td>
									<td>{!! $items['name'] !!}</td>
									<td>{!! $items['description'] !!}</td>
									<td>{!! $items['price'] !!}</td>
									<td>
											<div class="col-xs-6 col-md-3">
												<a href="#" class="thumbnail">
													<img src="/{!! $items['thumbnail'] !!}" alt="...">
												</a>
											</div>
											<div class="col-xs-6 col-md-3">
												<a href="#" class="thumbnail">
													<img src="/{!! $items['image_address'] !!}" alt="...">
												</a>
											</div>	
									</td>
									<td>
										@if($items['status'] == 1)
										<span class="label label-success">active</span>
										@else
										<span class="label label-danger">not active</span>
										@endif
									</td>
									<td>
										<a class="btn btn-info btn-sm" href="{!! action('MenuItemsController@getEdit',$companies['id']) !!}"><i class="glyphicon glyphicon-pencil"></i></a>
									</td>
								</tr>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
				</li>
				@endforeach

			@endif
		</ul>


		<div class="panel-footer">
			<a class="btn btn-primary" href="{!!action('MenusController@getIndex')!!}">Edit Menu Groups</a>
			<a class="btn btn-info" href="{!!action('MenuItemsController@getIndex')!!}">Edit Menu Items</a>
		</div>
	</div>


</div>
<br/><br/><br/><br/>

@stop

