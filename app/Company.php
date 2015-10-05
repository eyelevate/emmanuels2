<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Company extends Model {
	protected $fillable = [];

	protected $table = 'companies';
	public static $rules = array(
		'name'=>'required|min:1',
	    'phone'=>'required|unique:companies,phone',
	    'email'=>'required|email|unique:companies,email',
	    'street'=>'required|min:2',
	    'zipcode'=>'required|numeric|min:2',
	    'city'=>'required|alpha|min:2',
	    'state'=>'required|alpha|min:2',
	    'country'=>'required|alpha|min:2',
	   
	);


	/*
	* Creates an array of time from 1:00 - 12:55
	* @param null
	* @return array
	*/
	public static function getDayHours (){
		$minutes = array(''=>'select time');

		$today_seconds_start = strtotime(date('Y-m-d ').'01:00:00');
		$today_seconds_end = strtotime(date('Y-m-d ').'12:55:00');

		for ($i=$today_seconds_start; $i <= $today_seconds_end; $i+=300) { 
			$time_collect = date('h:i',$i);
			$minutes[$time_collect] = $time_collect;
		}
		return $minutes;
	}

	public static function createCompanyList ($data){
		
		$companies = array();
		$get_countries = Company::country_code();
		if(count($data)>0){
			foreach ($data as $key => $value) {
				$id = $value['id'];
				$name = $value['name'];
				$nick_name = $value['nick_name'];
				$city = $value['city'];
				$state = $value['state'];
				$country = $get_countries[$value['country']];
				

				$zipcode = $value['zipcode'];
				$companies[$country][$city.', '.$state.' '.$zipcode][$key] = array(
					'id'=>$id,
					'name' => $name,
					'nick_name'=>$nick_name
				);

			}
		}

		return $companies;
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

	public static function prepareStoreHours($store_hours) {
		//create summary script for display only
		$store_hours_summary = array();
		if(isset($store_hours)) {
			foreach ($store_hours as $key => $value) {
				$opened = $value['open'];
				switch($key) {
					case 0:
						$day = 'Sunday';
					break;
					case 1:
						$day = 'Monday';
					break;
					case 2:
						$day = 'Tuesday';
					break;
					case 3:
						$day = 'Wednesday';
					break;
					case 4:
						$day = 'Thursday';
					break;
					case 5:
						$day = 'Friday';
					break;
					case 6:
						$day = 'Saturday';
					break;
				}
				$open_hour = ($opened == 'open') ? $value['open_hour'] : null;
				$open_minute = ($opened == 'open') ? str_pad($value['open_minute'], 2, '0', STR_PAD_LEFT) : null;
				$open_ampm = ($opened == 'open') ? $value['open_ampm'] : null;
				$open_time = ($opened == 'open') ? $open_hour.':'.$open_minute.$open_ampm : null;
				$close_hour = ($opened == 'open') ? $value['close_hour'] : null;
				$close_minute = ($opened == 'open') ? str_pad($value['close_minute'], 2, '0', STR_PAD_LEFT) : null;
				$close_ampm = ($opened == 'open') ? $value['close_ampm'] : null;
				$close_time = ($opened == 'open') ? $close_hour.':'.$close_minute.$close_ampm : null;
				$hour_range = ($opened == 'open') ? $open_hour.':'.$open_minute.$open_ampm.' - '.$close_hour.':'.$close_minute.$close_ampm : null;
				$store_hours_summary[$day] = array(
					'status'	=> $opened,
					'open' 		=> $open_time,
					'close'		=> $close_time,
				);
			}
		}


		return json_encode($store_hours_summary);
	}

	public static function prepareForView($data) {
		if(isset($data['store_hours'])) {
			$data['store_hours'] = json_decode($data['store_hours'],true);
		}
		if(isset($data['payment_period'])) {
			switch($data['payment_period']) {
				case 1: // 1st of the month
					$data['payment_period_display'] = '1st of the month';
				break;
				case 2:
					$data['payment_period_display'] = '15th of the month';
				break;
				default:
					$data['payment_period_display'] = '15th of the month';
				break;
			}
		}

		if(isset($data['phone'])) {
			$data['country'];
			$data['phone'] = Job::format_phone($data['phone'], $data['country']);
		}

		return $data;
	}

	public static function prepareForSelect($data) {
		$companies = array(''=>'All Companies');
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$company_id = $value['id'];
				$company_name = $value['name'];
				$company_nick_name = (isset($value['nick_name'])) ? ' ('.$value['nick_name'].')' : ''; 
				$companies[$company_id] = $company_name.$company_nick_name; 
			}
		}

		return $companies;
	}

	
}