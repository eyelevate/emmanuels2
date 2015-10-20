<?php

namespace App;
use App\Job;
use App\RoleUser;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {
	protected $fillable = [];
	    public static function PaymentSelect() {
        $cats = array(
        				''=>'Select Payment Type',
        				'1' => 'Naver Pay',
        				'2' => 'Direct Payment'
        			);
        return $cats;
    }
}