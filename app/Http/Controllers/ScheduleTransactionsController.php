<?php
namespace App\Http\Controllers;

use Input;
use Validator;
use Redirect;
use Hash;
use Request;
use Route;
use Response;
use Auth;
use URL;
use Session;
use Laracasts\Flash\Flash;
use View;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Admin;
use App\Role;
use App\Permission;
use App\PermissionRole;
use App\Invoice;
use App\Website;
use App\ScheduleTransaction;
use App\ScheduleRule;


class ScheduleTransactionsController extends Controller
{
    protected $layout = 'layouts.admin';
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct() {
        // // Define layout
        $this->layout = 'layouts.admins';
        $this_username = null;
        //PROFILE IMAGE
        $this_user_profile_image = null;
        if (Auth::check()) {
        $this_user = User::find(Auth::user()->id);
        $this_username = $this_user->username;

        //PROFILE IMAGE
        $this_user_profile_image = Job::imageValidator($this_user->profile_image);
        }
        View::share('this_username',$this_username);
        View::share('this_user_profile_image',$this_user_profile_image);
        $notif = Job::prepareNotifications();
        View::share('notif',$notif);
        //
        $this->role_id = (isset(Auth::user()->roles)) ? Auth::user()->roles : null;
        $init_message = Website::WebInit();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $schedule_t = ScheduleTransaction::prepareScheduleT(ScheduleTransaction::get());
        return view('schedule_transactions.queue')
        ->with('layout',$this->layout)
        ->with('schedule_t',$schedule_t);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAdd()
    {
        $country = Job::country_code();
        $search_by = User::search_by();
        $payment_select = Invoice::PaymentSelect();

        $rules = ScheduleRule::PrepareForSelect(ScheduleRule::get());

        return view('schedule_transactions.add')
        ->with('layout',$this->layout)
        ->with('search_by',$search_by)
        ->with('payment_select',$payment_select)
        ->with('country_code',$country)
        ->with('rules',$rules);
    }
    public function postAdd()
    {

    }


}
