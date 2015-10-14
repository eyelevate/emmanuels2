@extends($layout)
@section('stylesheets')
@stop
@section('scripts')
<!-- DATEPICKER -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
{!! Html::script('/assets/js/schedules_details_frontend.js') !!}
@stop

@section('content')
<div class="row" id="this-body" style="min-height:500px;"> 
	{!! Form::open(array('action' => 'SchedulesController@postDetails', 'class'=>'','id'=>'add-form','role'=>"form")) !!}
	<div class="col-md-3" style="margin-bottom:5px;">
		<ul id="stepy" class="nav nav-pills nav-stacked">
			<li id="type-stepy" class="active" role="presentation"><a href="#type"><span class="badge">1</span> Type</a></li>
			<li id="place-stepy" class="" role="presentation"><a href="#place"><span class="badge">2</span> Place</a></li>
			<li id="date-stepy" class="" role="presentation"><a href="#date"><span class="badge">3</span> Date</a></li>
		</ul>
	</div>
	<div class="col-md-9 pull-right">


		<!-- TYPE STEP -->
		<div id="type" class="steps panel panel-success " >
			<div class="panel-heading" style="font-size:17px;"><strong>Type</strong></div>
			<div class="panel-body">
				<!-- FIRST SECTION -->
				<div class="first_section">
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="estimate_or_order" id="estimate_radio" value="1"> 
								Schedule an Estimate &nbsp<i class="glyphicon glyphicon-info-sign" style="color:#337ab7;"></i>
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="estimate_or_order" id="cleaning_radio" value="2"> 
								Schedule a cleaning &nbsp<i class="glyphicon glyphicon-info-sign" style="color:#337ab7;"></i>
							</label>
						</div>
					</div>
				</div>
				<!-- FIRST SECTION **END-->
			</div>
			<div class="panel-footer clearfix">
				<button type="button" id="first-next" class="btn btn-primary pull-right next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
			
		</div>

 

		<!-- PLACE STEP -->
		<div id="place" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>Place</strong></div>
			<div class="panel-body">
				<!-- SECOND SECTION START -->
				<div class="second_section">
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="house_or_store" id="house_radio" value="1"> 
								In House &nbsp<i class="glyphicon glyphicon-info-sign" style="color:#337ab7;"></i>
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="house_or_store" id="store_radio" value="2"> 
								In Store &nbsp<i class="glyphicon glyphicon-info-sign" style="color:#337ab7;"></i>
							</label>
						</div>
					</div>
				</div>
				<!-- SECOND SECTION END -->
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="1"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="button" id="next-btn" class="btn btn-primary pull-right next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
			
		</div>



		<!-- DATE STEP -->
		<div id="date" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>Date</strong></div>
			<div class="panel-body">
				<div class="third_section">
					<div class="form-group hide" id="estimate_calendar">
						<label class="control-label" for="pick_up">Estimate Date&nbsp;&nbsp;</label>
						<div class="input-group ">
							<input type="text" value="" class="form-control  estimate-date " id="estimate-date" name="estimate_date" readonly="readonly" this-group="estimate" style="cursor:pointer;background-color:#fff"  placeholder="" aria-describedby="basic-addon2">
							<span class="input-group-addon calendar" style="cursor:pointer" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						<!-- estimate ERROR -->
						<span class="estimate-date-error help-block hide" style="color:#a94442;">Pick-Up date is required</span>
					</div>
					<div class="form-group hide" id="cleaning_calendar">
						<label class="control-label" for="pick_up">Cleaning Date&nbsp;&nbsp;</label>
						<div class="input-group ">
							<input type="text" value="" class="form-control  cleaning-date " id="cleaning-date" name="cleaning_date" readonly="readonly" this-group="cleaning" style="cursor:pointer;background-color:#fff"  placeholder="" aria-describedby="basic-addon2">
							<span class="input-group-addon calendar" style="cursor:pointer" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						<!-- cleaning ERROR -->
						<span class="cleaning-date-error help-block hide" style="color:#a94442;">Pick-Up date is required</span>
					</div>
				</div>
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="1"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="submit" id="submit-btn" class="btn btn-primary pull-right" >Submit <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
			
		</div>
	</div>
	{!! Form::close() !!}
</div>
<style>
.title-hr{
margin-top: 10px;
margin-bottom: 10px;
}
.group-title{
margin-top: 25px;
}
.main-group-title{
margin-top: 0px;
}
</style>
@stop