@extends($layout)
@section('stylesheets')
@stop
@section('scripts')
{!! Html::script('/assets/js/schedules_new_frontend.js') !!}
@stop

@section('content')

  

          <div class="col-md-6">
            <div class="well clearfix">
              <h2>Members</h2>
              <hr>
				{!! Form::open(array('action' => 'SchedulesController@postNew', 'class'=>'','id'=>'post-new','role'=>"form")) !!}
                <div class="form-group">
                  <label class="control-label" for="username">Username</label>
                  <input name="username" class="form-control" id="username"
                  placeholder="Enter username" type="username">
                </div>
                <div class="form-group">
                  <label class="control-label" for="Password">Password</label>
                  <input name="password" class="form-control" id="Password"
                  placeholder="Password" type="password">
                </div>
                <a href="{!! action('RemindersController@getForgot') !!}">Forgot your password?</a>

                <button type="submit" class="btn btn-primary pull-right">Log In</button>
            	</br>
                Are you a new user? <a class="" href="">Sign Up</a>
                {!! Form::hidden('member', true,array('id'=>'member')) !!}
               {!! Form::close() !!}
            </div>
          </div>

         <!-- GUESTS FORM -->
          <div class="col-md-6">
            <div class="well clearfix">
              <h2>Guests</h2>
              <hr>
              {!! Form::open(array('action' => 'SchedulesController@postNew', 'class'=>'','id'=>'add-form','role'=>"form")) !!}
                <div class="form-group {!! $errors->has('first_name') ? 'has-error' : false !!}">
                  <label class="control-label" for="First_name">First Name</label>
                  <input name="first_name" class="form-control" id="First_name"
                  placeholder="Enter first name" type="first_name">
                  	@foreach($errors->get('first_name') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach
                </div>
                <div class="form-group {!! $errors->has('last_name') ? 'has-error' : false !!}">
                  <label class="control-label" for="last_name">Last Name</label>
                  <input name="last_name" class="form-control" id="last_name"
                  placeholder="Enter last name" type="last_name">
                    @foreach($errors->get('last_name') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach
                </div>
                <div class="form-group {!! $errors->has('phone') ? 'has-error' : false !!}">
                  <label class="control-label" for="phone">Phone number</label>
                  <input name="phone" class="form-control" id="phone"
                  placeholder="Enter phone number" type="phone">
                    @foreach($errors->get('phone') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach                
				</div>
                <div class="form-group {!! $errors->has('email') ? 'has-error' : false !!}">
                  <label class="control-label" for="Email">Email address</label>
                  <input name="email" class="form-control" id="Email"
                  placeholder="Enter email" type="email">
                    @foreach($errors->get('email') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach                
				</div>
                <div class="form-group {!! $errors->has('street') ? 'has-error' : false !!}">
                  <label class="control-label" for="street">Street</label>
                  <input name="street" class="form-control" id="street"
                  placeholder="Enter street" type="street">
                    @foreach($errors->get('street') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach                
				</div>
                <div class="form-group {!! $errors->has('unit') ? 'has-error' : false !!}">
                  <label class="control-label" for="unit">Unit</label>
                  <input name="unit" class="form-control" id="unit"
                  placeholder="Enter unit" type="unit">
                    @foreach($errors->get('unit') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach                
				</div>
                <div class="form-group {!! $errors->has('city') ? 'has-error' : false !!}">
                  <label class="control-label" for="city">City</label>
                  <input name="city" class="form-control" id="city"
                  placeholder="Enter city" type="city">
                    @foreach($errors->get('city') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach                
				</div>
                <div class="form-group {!! $errors->has('state') ? 'has-error' : false !!}">
                  <label class="control-label" for="state">State</label>
                  <input name="state" class="form-control" id="state"
                  placeholder="Enter state" type="state">
                    @foreach($errors->get('state') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach                
				</div>
                <div class="form-group {!! $errors->has('zipcode') ? 'has-error' : false !!}">
                  <label class="control-label" for="zipcode">Zipcode</label>
                  <input name="zipcode" class="form-control" id="zipcode"
                  placeholder="Enter zipcode" type="zipcode">
                    @foreach($errors->get('zipcode') as $message)
					<span class='help-block'>{!! $message !!}</span>
					@endforeach                
				</div>
				<button type="submit" class="btn btn-primary pull-right">Continue As Guest &nbsp&nbsp <i class="
					glyphicon glyphicon-arrow-right"></i> </button>
					{!! Form::hidden('guest', true,array('id'=>'guest')) !!}
              {!! Form::close() !!}
            </div>
          </div>


@stop