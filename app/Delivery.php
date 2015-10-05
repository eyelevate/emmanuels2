<?php

class Delivery extends Eloquent {
	protected $fillable = [];
	use SoftDeletingTrait;
	protected $table = 'deliveries';
	public static $rules_deliveries_rules = array(

		);
	public static $rules_deliveries_add = array(
		'billing_first_name'=>'required|min:1',
		'billing_last_name'=>'required|min:1',
		'billing_phone'=>'required',
		'billing_email'=>'required|email',
		'billing_street'=>'required|min:2',
		'billing_zipcode'=>'required|numeric|min:2',
		'billing_city'=>'required|alpha|min:2',
		'billing_state'=>'required|min:2',
		'billing_payment_options'=>'required',
		'billing_cc_number' => 'required',
		'billing_cc_type' => 'required',
		'billing_cc_month'=>'required',
		'billing_cc_year'=>'required'
		);
	public static $rules_deliveries_edit = array(
		'billing_first_name'=>'required|min:1',
		'billing_last_name'=>'required|min:1',
		'billing_phone'=>'required',
		'billing_email'=>'required|email',
		'billing_street'=>'required|min:2',
		'billing_zipcode'=>'required|numeric|min:2',
		'billing_city'=>'required|alpha|min:2',
		'billing_state'=>'required|min:2',
		'billing_payment_options'=>'required',
		'billing_cc_number' => 'required',
		'billing_cc_type' => 'required',
		'billing_cc_month'=>'required',
		'billing_cc_year'=>'required'
		);

	public static function prepare($data){
		if(isset($data)){
			foreach ($data as $key => $value) {
				$companies = Company::find($data[$key]['company_id']);
				$data[$key]['company_name'] = $companies->name;
				if(isset($data[$key]['firstname'])) {
					$data[$key]['firstname'] = ucfirst($data[$key]['firstname']);
				}
				if(isset($data[$key]['lastname'])) {
					$data[$key]['lastname'] = ucfirst($data[$key]['lastname']);
				}
				if(isset($data[$key]['phone'])){
					$data[$key]['phone'] = Job::format_phone($data[$key]['phone'], $data[$key]['country']);
				}
				if(isset($data[$key]['city'])) {
					$data[$key]['city'] = ucfirst($data[$key]['city']);
				}
				if(isset($data[$key]['state'])) {
					$data[$key]['state'] = ucfirst($data[$key]['state']);
				}
				if(isset($data[$key]['status'])) {
					switch ($data[$key]['status']) {
						case 1:// Created by user
						$data[$key]['status_html'] = '<span class="label label-primary">Created</span>';
						break;
						case 2:// Accepted by owner
						$data[$key]['status_html'] = '<span class="label label-info">Accepted</span>';
						break;
						case 3:// In-process
						$data[$key]['status_html'] = '<span class="label label-info">In Process</span>';
						break;
						case 4:// In-delivery
						$data[$key]['status_html'] = '<span class="label label-info">In Delivery</span>';
						break;
						case 5:// Completed
						$data[$key]['status_html'] = '<span class="label label-success">Completed</span>';
						break;
						case 6:// Cancelled
						$data[$key]['status_html'] = '<span class="label label-default">Cancelled</span>';
						break;					
						default://errors
						$data[$key]['status_html'] = '<span class="label label-danger">Error</span>';
						break;
					}
				}
				if(isset($data[$key]['start'])) {
					$data[$key]['start'] = date ( 'n/d/Y g:ia',  strtotime($data[$key]['start']) );
				}
				if(isset($data[$key]['end'])) {
					$data[$key]['end'] = date ( 'n/d/Y g:ia',  strtotime($data[$key]['end']) );
				}
			}
		}

		return $data;
	}



	public static function prepareForSave($data){
		if(isset($data['billing_first_name'])) {
			$data['billing_first_name'] = ucfirst($data['billing_first_name']);
		}
		if(isset($data['billing_last_name'])) {
			$data['billing_last_name'] = ucfirst($data['billing_last_name']);
		}
		if(isset($data['billing_phone'])) {
			$data['billing_phone'] = preg_replace("/[^0-9]/","",$data['billing_phone']);
		}
		if(isset($data['billing_city'])) {
			$data['billing_city'] = ucfirst($data['billing_city']);
		}
		if(isset($data['billing_state'])) {
			$data['billing_state'] = Delivery::states_reversed($data['billing_state']);
		}
		return $data;
	}

	public static function prepareScheduleForEdit($deliveries){
		if (isset($deliveries)) {
			if ($deliveries['takeout'] != 1) {//CHECK IF THE DELIVERY IS NOT TAKEOUT
				$deliveries['pickup_date'] = date('l, j F, Y',strtotime($deliveries['pickup_start']));
				$deliveries['pickup_start'] = date('g:i a',strtotime($deliveries['pickup_start']));
				$deliveries['pickup_end'] = date('g:i a',strtotime($deliveries['pickup_end']));
				$deliveries['dropoff_date'] = date('l, j F, Y',strtotime($deliveries['dropoff_start']));
				$deliveries['dropoff_start'] = date('g:i a',strtotime($deliveries['dropoff_start']));
				$deliveries['dropoff_end'] = date('g:i a',strtotime($deliveries['dropoff_end']));
			}

		}
		return $deliveries;
	}
	private static function states_reversed($state) {
		$state = ucfirst(strtolower($state));
		if(strlen($state) > 2) {
			$states = array(
				'Alabama'=>'AL',
				'Alaska'=>'AK',
				'Arizona'=>'AZ',
				'Arkansas'=>'AR',
				'California'=>'CA',
				'Colorado'=>'CO',
				'Connecticut'=>'CT',
				'Delaware'=>'DE',
				'Florida'=>'FL',
				'Georgia'=>'GA',
				'Hawaii'=>'HI',
				'Idaho'=>'ID',
				'Illinois'=>'IL',
				'Indiana'=>'IN',
				'Iowa'=>'IA',
				'Kansas'=>'KS',
				'Kentucky'=>'KY',
				'Louisiana'=>'LA',
				'Maine'=>'ME',
				'Maryland'=>'MD',
				'Massachusetts'=>'MA',
				'Michigan'=>'MI',
				'Minnesota'=>'MN',
				'Mississippi'=>'MS',
				'Missouri'=>'MO',
				'Montana'=>'MT',
				'Nebraska'=>'NE',
				'Nevada'=>'NV',
				'New Hampshire'=>'NH',
				'New Jersey'=>'NJ',
				'New Mexico'=>'NM',
				'New York'=>'NY',
				'North Carolina'=>'NC',
				'North Dakota'=>'ND',
				'Ohio'=>'OH',
				'Oklahoma'=>'OK',
				'Oregon'=>'OR',
				'Pennsylvania'=>'PA',
				'Rhode Island'=>'RI',
				'South Carolina'=>'SC',
				'South Dakota'=>'SD',
				'Tennessee'=>'TN',
				'Texas'=>'TX',
				'Utah'=>'UT',
				'Vermont'=>'VT',
				'Virginia'=>'VA',
				'Washington'=>'WA',
				'West Virginia'=>'WV',
				'Wisconsin'=>'WI',
				'Wyoming'=>'WY'
				);
if(isset($states[$state])) {
	return $states[$state];
} else {
	return $state;
}

} else {
	return strtoupper($state);
}

}
public static function country_code(){
	return array
	(
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea (South)',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
		);		
}

public static function search_by() {
	return array(
		''			=> 'Search users by',
		'id'		=> 'user id',
		'username'	=> 'username',
		'phone'		=> 'phone number',
		'email'		=> 'email',
		'name'		=> 'full name'
		);
}

public static function createDeliveryTbody($name,$data) {
	$html = '';

	if(isset($data)) {
		foreach ($data as $delivery) {
			$html .= '<tr>';
			$html .= '<td>'.$delivery['id'].'</td>';
			$html .= '<td>'.$name.'</td>';
			$html .= '<td>'.$delivery['firstname'].'</td>';
			$html .= '<td>'.$delivery['lastname'].'</td>';
			$html .= '<td>'.$delivery['phone'].'</td>';
			$html .= '<td>'.$delivery['city'].'</td>';
			$html .= '<td>'.$delivery['street'].'</td>';
			$html .= '<td>'.$delivery['state'].'</td>';
			$html .= '<td>'.$delivery['region'].'</td>';
			$html .= '<td>'.$delivery['country'].'</td>';
			$html .= '<td>'.$delivery['zipcode'].'</td>';
			$html .= '<td>'.$delivery['start'].'</td>';
			$html .= '<td>'.$delivery['end'].'</td>';
			$html .= '<td>'.$delivery['status_html'].'</td>';
			$html .= '<td><a href="'.action('DeliveriesController@getEdit',$delivery['id']).'">Edit</a>/';
			$html .= '<form action="'.action('DeliveriesController@postDelete').'" class="remove-form" id="form-'.$delivery['id'].'" ';
			$html .= '<input type="hidden" name="delivery_id" value="'.$delivery['id'].'">';
			$html .= '<a class="remove"  data-toggle="modal" data-target="#myModal" delivery-id="'.$delivery['id'].'">Remove</a>';
			$html .= '</form></td>';
			$html .= '</tr>';
		}
	}

	return $html;
}



public static function prepareDirectCreditCardErrors($data)
{

	$card_errors = array();
	if(isset($data['details'])) {
		foreach ($data['details'] as $key => $value) {

			switch($value['field']) {
				case 'payer.funding_instruments[0].credit_card.number':
				$card_errors['billing_cc_number'] = $value['issue'];
				break;
				case 'payer.funding_instruments[0].credit_card.expire_month':
				$card_errors['billing_cc_exp'] = $value['issue'];
				break;
				case 'payer.funding_instruments[0].credit_card.expire_year':
				$card_errors['billing_cc_exp'] = $value['issue'];
				break;
				case 'payer.funding_instruments[0].credit_card.type':
				$card_errors['billing_cc_type'] = $value['issue'];
				break;
				case 'payer.funding_instruments[0].credit_card.first_name':
				$card_errors['billing_first_name'] = $value['issue'];
				break;
				case 'payer.funding_instruments[0].credit_card.last_name':
				$card_errors['billing_last_name'] = $value['issue'];
				break;
				default:
				$card_errors['billing_default'] = $value['issue'];
				break;
			}
			if(isset($value['name'])) {
				switch($value['name']) {
					case 'MALFORMED_REQUEST' :
					$card_errors['general_error'] = $value['message'][0];
					break;
				}
			}

		}
	}


	return $card_errors;
}

public static function prepareHtmlForDeliveriesAdd($schedule,$day,$zipcode) {
	$html = '';
	if(isset($schedule) && isset($day)) {
		foreach ($schedule as $key => $value) {
			if ($key == $day) {
				foreach ($value as $hkey => $hvalue) {
					foreach ($hvalue->area_code as $zkey => $zvalue) {
						
						
						if ($zvalue == $zipcode) {
							$html .= '<div class="alert hours-alert" style="cursor:pointer;margin-bottom: 3px;background-color:#E7E7E7;" role="alert">';
							$html .= '<input type="radio" class="hours-radio" name="_name" value="1"> &nbsp;&nbsp;Start from '.$hvalue->start.' To '.$hvalue->end.'<br>';
							$html .= '<input class="hours-start" type="hidden"  value="'.$hvalue->start.'">';
							$html .= '<input class="hours-end" type="hidden"  value="'.$hvalue->end.'">';
							$html .= '</div>';
						}
					}

					
				}
			}
		}
	}
	return $html;
}

public static function prepareHtmlForDeliveriesEditPickup($schedule,$day,$deliveries) {
	$html = '';

	if(isset($schedule) && isset($day)) {
		foreach ($schedule as $key => $value) {
			if ($key == $day) {
				foreach ($value as $hkey => $hvalue) {
					if (($deliveries['pickup_start'] == $hvalue->start)&&($deliveries['pickup_end'] == $hvalue->end)) {
						$html .= '<div class="alert hours-alert alert-success" style="cursor:pointer;margin-bottom: 3px;" role="alert">';
						$html .= '<input type="radio" checked class="hours-radio" name="pickup" value="1"> &nbsp;&nbsp;Start from '.$hvalue->start.' To '.$hvalue->end.'<br>';
						$html .= '<input class="hours-start" type="hidden"  value="'.$hvalue->start.'" name="pickup_start">';
						$html .= '<input class="hours-end" type="hidden"  value="'.$hvalue->end.'" name="pickup_end">';
						$html .= '</div>';
					} else {
						$html .= '<div class="alert hours-alert" style="margin-bottom: 3px;background-color:#E7E7E7;" role="alert">';
						$html .= '<input type="radio" class="hours-radio" name="_name" value="1"> &nbsp;&nbsp;Start from '.$hvalue->start.' To '.$hvalue->end.'<br>';
						$html .= '<input class="hours-start" type="hidden"  value="'.$hvalue->start.'">';
						$html .= '<input class="hours-end" type="hidden"  value="'.$hvalue->end.'">';
						$html .= '</div>';
					}

				}
			}
		}
	}
	return $html;
}

public static function prepareHtmlForDeliveriesEditDropoff($schedule,$day,$deliveries) {
	$html = '';

	if(isset($schedule) && isset($day)) {
		foreach ($schedule as $key => $value) {

			if ($key == $day) {
				foreach ($value as $hkey => $hvalue) {


					if (($deliveries['dropoff_start'] == $hvalue->start)&&($deliveries['dropoff_end'] == $hvalue->end)) {
						$html .= '<div class="alert hours-alert alert-success" style="cursor:pointer;margin-bottom: 3px;" role="alert">';
						$html .= '<input type="radio" checked class="hours-radio" name="dropoff" value="1"> &nbsp;&nbsp;Start from '.$hvalue->start.' To '.$hvalue->end.'<br>';
						$html .= '<input class="hours-start" type="hidden"  value="'.$hvalue->start.'" name="dropoff_start">';
						$html .= '<input class="hours-end" type="hidden"  value="'.$hvalue->end.'" name="dropoff_end">';
						$html .= '</div>';
					} else {
						$html .= '<div class="alert hours-alert" style="margin-bottom: 3px;background-color:#E7E7E7;" role="alert">';
						$html .= '<input type="radio" class="hours-radio" name="_name" value="1"> &nbsp;&nbsp;Start from '.$hvalue->start.' To '.$hvalue->end.'<br>';
						$html .= '<input class="hours-start" type="hidden"  value="'.$hvalue->start.'">';
						$html .= '<input class="hours-end" type="hidden"  value="'.$hvalue->end.'">';
						$html .= '</div>';
					}
				}
			}
		}
	}
	return $html;
}

public static function prepareTakeouts($takeouts,$rules) {
	$prepare_takeout = [];
	$prepare_takeout['now'] = "";
	$prepare_takeout['estimated_time']  = "";
	$prepare_takeout['takeout_in_queue'] = "";
	if(isset($takeouts,$rules)){
		$count = count($takeouts);
		$prepare_takeout['takeout_in_queue'] = $count;
		$rules_takeout_tat = (isset($rules->takeout_tat))?json_decode($rules->takeout_tat):null;
		$rules_takeout_limit = (isset($rules->takeout_limit))?$rules->takeout_limit:null;
		$rules_takeout_limit_inc = (isset($rules->takeout_limit_inc))?json_decode($rules->takeout_limit_inc):null;
		if (isset($rules_takeout_tat,$rules_takeout_limit,$rules_takeout_limit_inc)) {
			$now_timestamp = strtotime("now");
			$takeout_tat_timestamp = $now_timestamp;
			$day_string =  ($rules_takeout_tat->days != "") ? '+'.$rules_takeout_tat->days.' days' : '+0 days';
			$hours_string = ($rules_takeout_tat->hours != "") ? '+'.$rules_takeout_tat->hours.' hours' : '+0 hours';
			$minutes_string = ($rules_takeout_tat->minutes != "") ? '+'.$rules_takeout_tat->minutes.' minutes' : '+0 minutes';
			$tat_time_string = $day_string.', '.$hours_string.', '.$minutes_string;
			$takeout_tat_timestamp = date("Y-m-d H:i:s",$takeout_tat_timestamp);	
			$takeout_tat_timestamp = strtotime($takeout_tat_timestamp.$tat_time_string);
			$takeout_tat_time = ($takeout_tat_timestamp - $now_timestamp);
			if($count > $rules_takeout_limit){
				$takeout_inc_timestamp = $now_timestamp;
				$day_inc_string =  ($rules_takeout_limit_inc->days != "") ? '+'.$rules_takeout_limit_inc->days.' days' : '+0 days';
				$hours_inc_string = ($rules_takeout_limit_inc->hours != "") ? '+'.$rules_takeout_limit_inc->hours.' hours' : '+0 hours';
				$minutes_inc_string = ($rules_takeout_limit_inc->minutes != "") ? '+'.$rules_takeout_limit_inc->minutes.' minutes' : '+0 minutes';
				$inc_time_string = $day_inc_string.', '.$hours_inc_string.', '.$minutes_inc_string;
				$takeout_inc_timestamp = date("Y-m-d H:i:s",$takeout_inc_timestamp);	
				$takeout_inc_timestamp = strtotime($takeout_inc_timestamp.$inc_time_string);
				$takeout_inc_timestamp = ($takeout_inc_timestamp - $now_timestamp);
				$multiplier = $count - $rules_takeout_limit;
				$takeout_inc_timestamp = ($takeout_inc_timestamp * $multiplier);
				$takeout_tat_time = ($takeout_tat_time + $takeout_inc_timestamp);
			}
			$prepare_takeout['now'] =date("d F Y g:i a",$now_timestamp);
			$prepare_takeout['estimated_time'] = date("d F Y g:i a",($now_timestamp + $takeout_tat_time));
		}
	}
	return $prepare_takeout;
}
public static function prepareScheduleByZipcode($schedule,$zipcode) {
	$prepare_schedule = [] ;
	if(isset($schedule) ) {
		foreach ($schedule as $day_key => $day) {
			foreach ($day as $sset_key => $sset) {
				foreach ($sset->area_code as $area_key => $area_code) {
					if ($area_code == $zipcode) {
						$prepare_schedule[$day_key][$sset_key] = $sset;
						break;
					}
				}
			}
		}
	}
	if (empty($prepare_schedule)) {
		//save the requested area
		$rules = DeliveryRule::where('company_id',Input::get('company_id'))->first();
		$rules_requested_range = json_decode($rules->requested_range);
		$prepare_requested_area = Delivery::prepareRequestedArea($rules_requested_range,$zipcode);
		$rules->requested_range = json_encode($prepare_requested_area);
		$rules->save();
	}
	return $prepare_schedule;
}

public static function prepareRequestedArea($rules_range,$requested_range) {
	$nowtime = time();
	if(isset($requested_range)) {
			$check = 0;
			//if rules_range was not empty
			if (isset($rules_range)) {
				//check each rules range
				foreach ($rules_range as $key => $value) {
					//if the requested range exist update it
					if ($key == $requested_range) {
						array_push($rules_range->$key,$nowtime);
						$check = 1;
					} 
				}
				if ($check == 0) {
					//this is the fist to be added into this object
					$rules_range->$requested_range = [$nowtime];
				}
			} else {
				//Create new object
				$rules_range = new stdClass();
				$rules_range->$requested_range = [$nowtime];
			}

		
	}
	return $rules_range;
}

public static function prepareNewAreaForm($schedule,$zipcode,$company_id,$rules_range) {
	$prepare_area_form['isset'] = 0 ;
	$prepare_area_form['form'] = '' ;
	if(isset($schedule) ) {
		foreach ($schedule as $day_key => $day) {
			foreach ($day as $sset_key => $sset) {
				foreach ($sset->area_code as $area_key => $area_code) {
					if ($area_code == $zipcode) {
						$prepare_area_form['isset'] = 1;
						break;
					}
				}
			}
		}
		$arange_count = [];
		if(isset($rules_range)) {
			foreach ($rules_range as $key => $value) {
				$arange_count[count($rules_range->$key)][$key] = [$key];
			}
			krsort($arange_count);
		}
		if ($prepare_area_form['isset'] == 0) {
			$prepare_area_form['form'] .= '<div style="padding-bottom: 3px;" class="this-alert clearfix">Delivery to <span id="this_zipcode" style="text-decoration: underline;font-weight: bold;"></span> is not available. Would you like to add it to your delivery rules?';
			$prepare_area_form['form'] .= '<div class="btn-group pull-right" role="group" aria-label="...">';
			$prepare_area_form['form'] .= '<input type="hidden" readonly="readonly" class="area" name="area" value="'.$zipcode.'">';
			$prepare_area_form['form'] .= '<button style="border-top-left-radius:4px;border-bottom-left-radius:4px;" type="button" class="btn btn-sm btn-primary" id="yes_request">Yes</button>';
			$prepare_area_form['form'] .= '<button type="button" class="btn btn-sm btn-danger" id="no_request">No</button>';
			$prepare_area_form['form'] .= '<button type="button" class="btn btn-sm btn-info" id="later_request">Maybe Later</button>';	
			$prepare_area_form['form'] .= '</div>';	
			$prepare_area_form['form'] .= '</div>';	
			if (!empty($arange_count)) {
				$prepare_area_form['form'] .= '<hr id="alert-hr">';	
			}

		}
		if(isset($arange_count)) {
			$count = 0;
			foreach ($arange_count as $akey => $avalue) {
				
				foreach ($avalue as $aakey => $aavalue) {
					$count++;
					foreach ($aavalue as $key => $value) {
						$prepare_area_form['form'] .= '<div class="this-alert" style="padding-left:15px;padding-right:0;">';
							$prepare_area_form['form'] .= '<div><span class="badge" style="background-color:#428bca;">'.$count.'</span>&nbsp;&nbsp;&nbsp;You have <strong><u>'.$akey.'</u></strong> request to expand your delivery range to <span id="this_zipcode_new" style="text-decoration: underline;font-weight: bold;">'.$value.'</span>';
								$prepare_area_form['form'] .= '<div class="btn-group pull-right  clearfix" role="group" aria-label="...">';
									$prepare_area_form['form'] .= '<input type="hidden" readonly="readonly" class="area" name="area" value="'.$value.'">';
									$prepare_area_form['form'] .= '<button style="border-top-left-radius:4px;border-bottom-left-radius:4px;" type="button" class="btn btn-sm btn-primary" id="yes_request">Yes</button>';
									$prepare_area_form['form'] .= '<button type="button" class="btn btn-sm btn-danger" id="no_request">No</button>';
									$prepare_area_form['form'] .= '<button type="button" class="btn btn-sm btn-info" id="later_request">Maybe Later</button>';	
								$prepare_area_form['form'] .= '</div>';	
							$prepare_area_form['form'] .= '</div></br>';
						$prepare_area_form['form'] .= '</div>';
					}
				}

			}
		}
	}
	return $prepare_area_form;
}

public static function prepareHours($deliveries,$company_id) {
	$hours_preapred['pickup_hours'] = '' ;
	$hours_preapred['dropoff_hours'] = '' ;
	$hours_preapred['dropoff_date'] = '' ;
	$hours_preapred['takeout'] = 0 ;
	$rules = DeliveryRule::where('company_id',$company_id)->first();
	$days_schedule = json_decode($rules->delivery_schedules);
	if (isset($deliveries)) {
		if (isset($deliveries['pickup_date'])) {
			$selected_date = strtotime($deliveries['pickup_date']);
			$selected_day = date('w',$selected_date);
			$hours_preapred['pickup_hours'] = Delivery::prepareHtmlForDeliveriesEditPickup($days_schedule,$selected_day,$deliveries);
		}
		if (isset($deliveries['dropoff_date'])) {
			$hours_preapred['dropoff_date'] = $deliveries['dropoff_date'] ;
			$selected_date = strtotime($deliveries['dropoff_date']);
			$selected_day = date('w',$selected_date);
			$hours_preapred['dropoff_hours'] = Delivery::prepareHtmlForDeliveriesEditDropoff($days_schedule,$selected_day,$deliveries);
		}
		if (isset($deliveries['takeout'])) {
			if ($deliveries['takeout'] == 1) {
				$hours_preapred['takeout'] = 1;
			} 
		}


	}
	return $hours_preapred;
}

public static function prepareClassesForEdit($deliveries,$session) {
	$classes= [] ;
	$classes['pickup'] = "panel-default";
	$classes['pickup_date'] = "Select Pickup Date";
	$classes['dropoff'] = "panel-default";
	$classes['dropoff_date'] = "Select Dropoff Date";
	$classes['takeout'] = "";
	$classes['delivery'] = "active";
	$classes['takeout-div'] = "hide";
	$classes['delivery-div'] = "";
	//TAB TICKS
	$classes['takeout_tick'] = 'hide';
	$classes['delivery_tick'] = '';
	//PICKUP
	if (isset($session)) {
		if(($session['takeout'] != 1 )&& (isset($session['pickup_date']))){
			$classes['pickup'] = "panel-success";
			$classes['pickup_date'] = $session['pickup_date'];
		}
	} elseif ($deliveries->pickup_start){
		$classes['pickup'] = "panel-success";
		$classes['pickup_date'] = date('l, j F, Y',strtotime($deliveries['pickup_start']));

	} 
	//DROPOFF
	if (isset($session)) {
		if(($session['takeout'] != 1 ) && (isset($session['dropoff_date']))){
			$classes['dropoff'] = "panel-success";
			$classes['dropoff_date'] = $session['dropoff_date'];
		}
	} elseif ($deliveries->dropoff_start){
		$classes['dropoff'] = "panel-success";
		$classes['dropoff_date'] = date('l, j F, Y',strtotime($deliveries['dropoff_start']));
	} 
	//TAKEOUT
	if (isset($session)) {
		if($session['takeout'] == 1 ){
			$classes['takeout'] = "active";
			$classes['delivery'] = "";
			$classes['takeout-div'] = "";
			$classes['delivery-div'] = "hide";

			//ticks
			$classes['takeout_tick'] = '';
			$classes['delivery_tick'] = 'hide';
		}
	} elseif ($deliveries->takeout == 1){
		$classes['takeout'] = "active";
		$classes['delivery'] = "";
		$classes['takeout-div'] = "";
		$classes['delivery-div'] = "hide";
		//ticks
		$classes['takeout_tick'] = '';
		$classes['delivery_tick'] = 'hide';
	} 


	return $classes;
}

public static function prepareClassesForAdd($session) {
	$classes= [] ;
	$classes['pickup'] = "panel-default";
	$classes['pickup_date'] = "Select Pickup Date";
	$classes['pickup_start'] = "";
	$classes['pickup_end'] = "";
	$classes['pickup_isset'] = false;
	$classes['dropoff'] = "panel-default";
	$classes['dropoff_date'] = "Select Dropoff Date";
	$classes['dropoff_start'] = "";
	$classes['dropoff_end'] = "";
	$classes['dropoff_isset'] = false;
	$classes['takeout'] = "";
	$classes['delivery'] = "active";
	$classes['takeout-div'] = "hide";
	$classes['delivery-div'] = "";

	//this is for company session
	$classes['company'] = '';

	//TAB TICKS
	$classes['takeout_tick'] = 'hide';
	$classes['delivery_tick'] = '';

	//for the checklist
	$classes['isset_date'] = 0;

	if (isset($session)) {
		//COMPANY SESSION
		$classes['company'] = '<input type="hidden" value="'.$session['company_id'].'" name="company_session" id="company_session" readonly/>';
		//get the rules for hours
		$rules = DeliveryRule::where('company_id',$session['company_id'])->first();
		$days_schedule = json_decode($rules->delivery_schedules);
		//TAKEOUT
		if ($session['takeout'] == 1) {
			$classes['takeout'] = "active";
			$classes['takeout-div'] = "";
			$classes['delivery'] = "";
			$classes['delivery-div'] = "hide";

			//ticks
			$classes['takeout_tick'] = '';
			$classes['delivery_tick'] = "hide";
		} else {
			//ticks
			$classes['takeout_tick'] = 'hide';
			$classes['delivery_tick'] = '';
		}

		//PICKUP
		if (($session['takeout'] != 1)&&(isset($session['pickup_date']))) {

			$selected_date = strtotime($session['pickup_date']);
			$selected_day = date('w',$selected_date);
			$classes['pickup_date'] = $session['pickup_date'];
			$classes['pickup_hours_div'] = Delivery::prepareHtmlForDeliveriesEditPickup($days_schedule,$selected_day,$session);
			$classes['pickup'] = "panel-success";
			$classes['pickup_start'] = $session['pickup_start'];
			$classes['pickup_end'] = $session['pickup_end'];
			$classes['pickup_isset'] = true;
			$classes['isset_date'] = 1;
		}

		//DROPOFF
		if (($session['takeout'] != 1)&&(isset($session['dropoff_date']))) {
			$selected_date = strtotime($session['dropoff_date']);
			$selected_day = date('w',$selected_date);
			$classes['dropoff_date'] = $session['dropoff_date'];
			$classes['dropoff_hours_div'] = Delivery::prepareHtmlForDeliveriesEditDropoff($days_schedule,$selected_day,$session);
			$classes['dropoff'] = "panel-success";
			$classes['dropoff_date'] = $session['dropoff_date'];
			$classes['dropoff_start'] = $session['dropoff_start'];
			$classes['dropoff_end'] = $session['dropoff_end'];
			$classes['dropoff_isset'] = true;
			$classes['isset_date'] = 1;
		}
	}


	return $classes;
}


public static function prepareRequestedRangeSession($requested_range) {
	$html = '';
	if(isset($requested_range)) {
		foreach ($requested_range as $key => $value) {
			$html .= '<input type="hidden" class="requested_area" readonly="readonly" name="requested_area['.$key.']" value="'.$value.'"/>';
		}
	}
	return $html;
}

}
