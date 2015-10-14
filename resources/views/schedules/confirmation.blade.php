@extends($layout)
@section('stylesheets')
@stop
@section('scripts')
{!! Html::script('/assets/js/schedules_preview.js') !!}
@stop
@section('content')
{!! Form::open(array('action' => 'SchedulesController@postConfirmation', 'class'=>'','id'=>'add-form','role'=>"form")) !!}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-md-3 col-lg-3 pull-left">
                    <div class="panel panel-default height">
                        <div class="panel-heading"><strong>Customer Details</strong></div>
                        <div class="panel-body">

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="panel panel-default height">
                        <div class="panel-heading"><strong>Billing address</strong></div>
                        <div class="panel-body">
                            <!-- CHECK WHETHER NEW ADDRESS WAS SET OR NOW -->

                        </div>
                    </div>
                </div>
                    <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="panel panel-default height">
                        <div class="panel-heading"><strong>Schedule Details</strong></div>
                        <div class="panel-body">
                            <!-- CHECK WHETHER NEW ADDRESS WAS SET OR NOW -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-center"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td class="text-center"><strong>Name</strong></td>
                                    <td class="text-center"><strong>Type</strong></td>
                                    <td class="text-center"><strong>Height</strong></td>
                                    <td class="text-center"><strong>Length</strong></td>
                                    <td class="text-center"><strong>Price</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-right"><strong>Total</strong></td>
                                </tr>
                            </thead>
                            <tbody>	
                            	<!-- FILL THE TABLE -->
        
                                <tr>
                                    <td class="highrow"><strong>Name</strong></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow text-center"><strong>Subtotal</strong></td>
                                    <td class="highrow text-right"></td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-center"><strong>Tax rate</strong></td>
                                    <td class="emptyrow text-right"></td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-center"><strong>Tax due</strong></td>
                                    <td class="emptyrow text-right"></td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"><i class="fa fa-barcode iconbig"></i></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-center"><strong>Total</strong></td>
                                    <td class="emptyrow text-right"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
	            <div class="panel-footer">

                            <a href="{!! action('SchedulesController@getAdd') !!}" class="previous btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>

					<button type="submit" class="btn btn-primary pull-right submit-btn">Confirm</button>
				</div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<style>
.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}

</style>
@stop