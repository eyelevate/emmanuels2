<?php

class ScheduleLimit extends \Eloquent {
	protected $fillable = [];

	public static function prepareValidationResults($data){
		$message = [];
		if (isset($data)) {
			$today = date('m/d/y');
			foreach ($data as $key => $value) {
				$message[$key]['start'] =  strtotime($today.' '.$value[0].':'.$value[1].' '.$value[2]);
				$message[$key]['end'] =  strtotime($today.' '.$value[3].':'.$value[4].' '.$value[5]);
				if ($message[$key]['end'] < $message[$key]['start']) {
					$message[$key]['info'] = "error";
				} else {
					$message[$key]['info'] = "fine";
				}
			}
		}
		return $message;
	}

	public static function prepareValidationOverWriteResults($data){
		$message = [];
		if (isset($data)) {
			$today = date('m/d/y');
			foreach ($data as $key => $value) {
				$message[$key]['start'] =  strtotime($today.' '.$value[0].':'.$value[1].' '.$value[2]);
				$message[$key]['end'] =  strtotime($today.' '.$value[3].':'.$value[4].' '.$value[5]);
				if ($message[$key]['end'] < $message[$key]['start']) {
					$message[$key]['info'] = "error";
				} else {
					$message[$key]['info'] = "fine";
				}
			}
		}
		return $message;
	}

	public static function prepareNewOverwrite($new_count) {
			
		$overwrite_hours = array();
		$overwrite_minutes = array();
		$overwrite_ampm = array('am'=>'am','pm'=>'pm');
		for ($i=0; $i < 13; $i++) { 
			if ($i == 0) {
				$overwrite_hours[$i] = 'Select hour';
			} else if($i < 10){
				$overwrite_hours['0'.$i] = $i;
			} else {
				$overwrite_hours[$i] = $i;
			}
		}
		for ($i=0; $i <= 60; $i++) {
			if($i == 0) {
				$overwrite_minutes[""] = 'Select minute';
			} else if($i < 11){
				$new_i = $i - 1;
				$overwrite_minutes['0'.$new_i] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
			} else {
				$overwrite_minutes[$i-1] = ":".str_pad($i-1, 2, '0', STR_PAD_LEFT);
			}
		}
		if(isset($new_count)) {
			$html = '';
			$html = '
					<div class="panel panel-default content-set this-wrapper" this-set="'.$new_count.'" style="margin-top:10px;border:none;border-radius:0;  border-bottom: 1px solid rgb(174, 174, 174);
						border-top: 1px solid rgb(174, 174, 174);">

						<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"
						data-parent="#accordion" href="#accordion-'.$new_count.'" aria-expanded="true" aria-controls="collapseOne"
						style="cursor: pointer;border:none;">
						<h4 class="panel-title">
							<a class="this-title">
								OverWrite Date '.($new_count+1).' <span style="color:#d9534f" class="hide glyphicon glyphicon-warning-sign this-error-sign this-error-sign-'.$new_count.'"></span>
							</a>
							<a>
								<i class="glyphicon glyphicon-chevron-down pull-right"></i>
							</a>
						</h4>
						</div>
						<div id="accordion-'.$new_count.'" this-set="'.$new_count.'" class="panel-collapse collapse in collapse-'.$new_count.'" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body panel-input">
								<!-- PANEL START -->

								<div class="overwrite-container">
									<!-- PANEL START -->
									<div class="panel-body overwrite-wrapper"  style="padding: 6px;">

										<h4 class="first-group-title">Type</h4>
										<hr class="title-hr">
										<div class="form-group">
											<select class="form-control type-select" name="overwrite['.$new_count.'][type]">
												<option value="single">Single</option>
												<option value="range">Range</option>
											</select>
										</div>


										<h4 class="group-title">Date</h4>
										<hr class="title-hr">

										<div class="single-wrapper box">
											<div class="input-group input-group-md">
												<span class="input-group-addon" >Select Date</span>
												<input type="text" name="overwrite['.$new_count.'][date]" id="overwrite-date-single-'.$new_count.'" class="form-control overwrite-date-single"  aria-describedby="sizing-addon1">
											</div>
											<divc class="hide single-date-error error" style="color:#a94442">The date field is required</div>
										</div>

										<div  class=" hide range-wrapper box">
											<div class="input-group input-group-md">
												<span class="input-group-addon" >Start Date</span>
												<input type="text" name="overwrite['.$new_count.'][start]"  id="overwrite-date-range-start-'.$new_count.'" class="form-control overwrite-date-range-start"  aria-describedby="sizing-addon'.$new_count.'">
											</div>
											<div class="hide start-date-error error" style="color:#a94442">The start field is required</div>
											<div class="box">
												<div class="input-group input-group-md" style="margin-top:10px;">
													<span class="input-group-addon" >End Date</span>
													<input type="text" name="overwrite['.$new_count.'][end]"  id="overwrite-date-range-end-'.$new_count.'" class="form-control overwrite-date-range-end"  aria-describedby="sizing-addon'.$new_count.'">
												</div>
												<div class="hide end-date-error error" style="color:#a94442">The end field is required</div>
											</div>
										</div>

										<h4 class="group-title">Schedules</h4>
										<hr class="title-hr">

										<!-- TABLE START -->
										<table class="table table-bordered table-condensed overwrite_hours_container" style="border:none">
											<tbody>
												<tr>
													<td class="list-group" style="border:none;">
														<fieldset>
															<div class="list-group-item" style="height:90px;">
																<h4 class="list-group-item-heading">Start</h4>
																<div class="col-xs-4">
																<div class="form-group ">
																	<select class="form-control form-selects overwrite-select-hour-open" placeholder="Select Hour" this_category="'.$new_count.'" status="" name="overwrite['.$new_count.'][open_hour]">';
																		foreach ($overwrite_hours as $key => $value) {
																			$html .= '<option value="'.$key.'">'.$value.'</option>';
																		}
																		$html .= '
																	</select>
																	<div class="select-error hide" style="color:#a94442">The hour field is required</div>
																</div>
																</div>
																<div class="col-xs-4">
																<div class="form-group ">
																	<select class="form-control form-selects overwrite-select-minute-open" placeholder="Select Minutes" this_category="'.$new_count.'" status="" name="overwrite['.$new_count.'][open_minute]">';
																		foreach ($overwrite_minutes as $key => $value) {
																			$html .= '<option value="'.$key.'">'.$value.'</option>';
																		}
																		$html .= '
																	</select>	
																	<div class="select-error hide" style="color:#a94442">The minute field is required</div>															
																	</div>
																	</div>
																<div class="col-xs-4">
																<div class="form-group ">
																	<select class="form-control form-selects overwrite-select-ampm-open" placeholder="" status="" this_category="'.$new_count.'" name="overwrite['.$new_count.'][open_ampm]">';
																		foreach ($overwrite_ampm as $key => $value) {
																			$html .= '<option value="'.$key.'">'.$value.'</option>';
																		}
																		$html .= '
																	</select>	
																	<div class="select-error hide" style="color:#a94442">This field is required</div>															
																	</div>
																	</div>
															</div>
															<div class="list-group-item" style="height:90px;">
																<h4 class="list-group-item-heading">End</h4>
																<div class="col-xs-4">
																<div class="form-group ">
																	<select class="form-control form-selects overwrite-select-hour-close" placeholder="Select Hour" this_category="'.$new_count.'" status="" name="overwrite['.$new_count.'][close_hour]">';
																	foreach ($overwrite_hours as $key => $value) {
																		$html .= '<option value="'.$key.'">'.$value.'</option>';
																	}
																	$html .= '
																	</select>	
																	<div class="select-error hide" style="color:#a94442">The hour field is required</div>															
																	</div>
																	</div>
																<div class="col-xs-4">
																	<div class="form-group ">
																		<select class="form-control form-selects overwrite-select-minute-close" placeholder="Select Minutes" this_category="'.$new_count.'" status="" name="overwrite['.$new_count.'][close_minute]">';
																		foreach ($overwrite_minutes as $key => $value) {
																			$html .= '<option value="'.$key.'">'.$value.'</option>';
																		}
																		$html .= '
																		</select>
																		<div class="select-error hide" style="color:#a94442">The minute field is required</div>																
																	</div>
																</div>
																<div class="col-xs-4">
																	<div class="form-group ">
																		<select class="form-control form-selects overwrite-select-ampm-close" placeholder="" status="" this_category="'.$new_count.'" name="overwrite['.$new_count.'][close_ampm]">';
																			foreach ($overwrite_ampm as $key => $value) {
																				$html .= '<option value="'.$key.'">'.$value.'</option>';
																			}
																			$html .= '
																		</select>	
																		<div class="select-error hide" style="color:#a94442">This field is required</div>															
																	</div>
																</div>
																<span id="time-error-overwrite-'.$new_count.'" class=" time-error-overwrite hide" style="color:#a94442;width:50px;">End time cannot be before start time</span>
															</div>
														</fieldset>
													</td>
												</tr>
											</tbody>
										</table>
										<!-- TABLE END -->

										<h4 class="group-title">Limit</h4>
										<hr class="title-hr">

										<div class="input-group input-group-md">
											<span class="input-group-addon" >Number Of Employees</span>
											<input type="text" name="overwrite['.$new_count.'][number_of_employee]" class="form-control employees-no"  aria-describedby="sizing-addon1">
										</div>
										<span class="hide employees-no-error" style="color:#a94442;width:50px;">This field is required</span>
										<span class="hide employees-no-error-numeric" style="color:#a94442;width:50px;">This field must only contain number</span>


									</div>
									<!-- PANEL END -->
								</div>
								<!-- PANEL END -->
							</div>
							<div class="panel-footer clearfix">
								<button type="button" class="btn btn-danger btn-sm pull-right remove-overwrite" >Remove <i class="glyphicon glyphicon-trash"></i></button>
							</div>
						</div>

					</div>
					';
		}
		return $html;
	}
}