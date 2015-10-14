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
use App\Thread;
use App\Category;
use App\RoleUser;
use App\Admin;

class UsersController extends Controller
{
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

        $this->role_id = (isset(Auth::user()->roles)) ? Auth::user()->roles : null;
    }
    public function getIndex() {
        if ($this->role_id == 1) {
            $user_id = Auth::user()->id;
            $users = User::prepare(User::all());
            $this->layout->content = View::make('users.index')
            ->with('user_id',$user_id)
            ->with('users',$users);
        } else if($this->role_id == 2) {
            $user_id = Auth::user()->id;
            $users = User::prepare(User::whereNotIn('roles', array(1))->get());
            return view('users.index')
            ->with('layout','layouts.admins')
            ->with('user_id',$user_id)
            ->with('users',$users);
        }
    }

    public function getAdd() {
        $roles = Admin::roles();
        return view('users.add')
        ->with('layout',$this->layout)
        ->with('roles',$roles);
    }

    public function postAdd() {
        $validator = Validator::make(Input::all(), User::$rules_add);

        if ($validator->passes()) {
            $user = new User;
            $user->roles = Input::get('roles');
            $user->username = Input::get('username');
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));

             if($user->save()) { // Save the user and redirect to owners home
                return Redirect::action('UsersController@getIndex')
                ->with('message', 'New User '.$user->username.' Successfully Registered!')
                ->with('alert_type','alert-success');
             }

         } else {
            // validation has failed, display error messages    
            return Redirect::back()
            ->with('message', 'The following errors occurred')
            ->with('alert_type','alert-danger')
            ->withErrors($validator)
            ->withInput();          
         }  
    }

    public function getEdit($id = null) {   
        $roles = Admin::roles();
        $admins = User::find($id);
        return view('users.edit')
        ->with('layout',$this->layout)
        ->with('roles',$roles)
        ->with('admins',$admins);
    }

    public function postEdit() {
        
        $current_user_id = Auth::user()->id;
        $id = Input::get('id');
        $username = Input::get('username');
        $save_user = User::find($id);

        if ($save_user->username == $username) {
            if (Input::get('password')) {
                $validator = Validator::make(Input::all(), User::$rules_edit_name);
            } else {
                $validator = Validator::make(Input::all(), User::$rules_not_password);
            }
        } else {
            if (Input::get('password')) {
                 $validator = Validator::make(Input::all(), User::$rules_edit);
            } else {
                $validator = Validator::make(Input::all(), User::$rules_not_password_alt);
            }
        }
        if ($validator->passes()) {
            // validation has passed, save user in DB
            $user = User::find($id);
            $user->roles = Input::get('roles');
            $user->username = Input::get('username');
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            if(Input::get('password') != ''){    
                $user->password = Hash::make(Input::get('password'));
            }
            if($user->save()) {
                return Redirect::action('UsersController@getIndex',$id)
                ->with('message', 'Admin Successfully Updated')
                ->with('alert_type','alert-success');
            } else {
                // Could not save changes  
                return Redirect::to('admins/index')
                ->with('message', 'ops, somthing went wrong. Please try again.')
                ->with('alert_type','alert-danger');    
            }
        } else {
            // validation has failed, display error messages    
            return Redirect::back()
            ->with('message', 'The following errors occurred')
            ->with('alert_type','alert-danger')
            ->withErrors($validator)
            ->withInput();  
        }   
    }

    public function postDelete()
    {

        $user_id = Input::get('user_id');
        $current_user_id = Auth::user()->id;
        if (($current_user_id != $user_id) && ($this->role_id < 3)) {
            $user = User::find($user_id);
            if($user->delete()) {
                return Redirect::action('UsersController@getIndex')
                ->with('message', 'Successfully deleted!')
                ->with('alert_type','alert-success');
            } else {
                return Redirect::back()
                ->with('message', 'Oops, somthing went wrong. Please try again.')
                ->with('alert_type','alert-danger');    
            }
        } else {
            return Redirect::back()
            ->with('message', 'Permission denied.')
            ->with('alert_type','alert-danger');
        }

    }
        public function postRequestUsers() {
        if(Request::ajax()) {
            $company_id = Input::get('company_id');
            $search = Input::get('search');
            $users = array();
            $status = 200;
            $message = 'Successfully found users!';
            if($search) {
                foreach ($search as $key => $value) {
                    $type = $key;
                    switch ($type) {
                        case 'name':
                        $first_name = $value['first_name'];
                        $last_name = $value['last_name'];
                        $users = User::where('firstname','LIKE','%'.$first_name.'%')
                        ->where('lastname','LIKE','%'.$last_name.'%')
                        ->get();

                        if(count($users) == 0){
                            $status = 401;
                            $message = 'No such name.';
                        }
                        break;
                        case 'phone':
                        foreach ($value as $column_name => $column_value) {

                            $phone_modified = preg_replace("/[^0-9]/","",trim($column_value));
                            if(!empty($phone_modified)) {
                                $users = User::where($column_name,'LIKE','%'.$phone_modified.'%')->get();
                            } else {
                                $users = null;
                                $status = 401;
                                $message = 'No such phone number';
                            }

                        }
                        break;
                        default:
                        foreach ($value as $column_name => $column_value) {
                            $users = User::where($column_name,'LIKE','%'.$column_value.'%')->get();
                        }
                        if(count($users) == 0) {
                            $status = 401;
                            $message = 'No such user';
                        }
                        break;
                    }
                }
            }

            $users_tbody = User::prepareForDeliveryTable($users);
            return Response::json(array(
                'status' => $status,
                'message' => $message,
                'users_tbody'   => $users_tbody
                ));
        }
    }
    public function postRequestUserInformation() {
        if(Request::ajax()) {
            $user_data=[];
            $id = Input::get('user_id');
            $users = User::find($id);
            if (isset($users)) {
                $user_data['username']  = $users->username;
                $user_data['firstname'] = $users->firstname;
                $user_data['lastname']  = $users->lastname;
                $user_data['email'] = $users->email;

                //GET THE PHONE NUMBER AND RE-FORMATE IT
                $user_data['phone'] = Job::format_phone($users->phone,'US');

                $user_data['roles'] = $users->roles;

                $user_data['street']  = $users->street;
                $user_data['city']    = $users->city;
                $user_data['state']   = $users->state;
                $user_data['zipcode'] = $users->zipcode;
                $user_data['unit']    = $users->unit;

            }
            return Response::json(array(
                'status' => 200,
                'user_data' => $user_data
                ));
        }
    }
    public function getRegistration()
    {
        return view('users.registration')
        ->with('layout',$this->layout);
    }
    public function postRegistration()
    {
        $validator = Validator::make(Input::all(), User::$registration);
        if ($validator->passes()) {
            $user = new User;
            $user->roles = 2;
            $user->username = Input::get('username');
            $user->firstname = Input::get('first_name');
            $user->lastname = Input::get('last_name');
            $user->email = Input::get('email');
            $user->age = Input::get('age');
            $user->company = (Input::get('company'))?Input::get('company'):null;
            $user->password = Hash::make(Input::get('password')); 

            //REFORMATE IMAGE NAME
            if (Input::get('profile-image')) {
                $imagePath = public_path("assets/images/profile-images/perm/");
                $now_time = time();
                $imagename = Input::get('profile-image');
                $image_ex = explode('.', $imagename);
                $image_type = $image_ex[1];
                $new_imagename = $now_time . '-' . $imagename[0];
                $final_path = preg_replace('#[ -]+#', '-', $new_imagename);
            }

            $user->profile_image = Input::get('profile-image')?$final_path.'.'.$image_type:'blank_male.png';           
             if($user->save()) { // Save the user and redirect to owners home

                //ASSIGN LEVEL TWO ACL (GUESTS)
                $new_rule = new RoleUser;
                $new_rule->role_id = 5;
                $new_rule->user_id = $user->id;

                if($new_rule->save()) {
                    if (Input::get('profile-image')) {
                        if( ! \File::isDirectory($imagePath) ) {
                            \File::makeDirectory($imagePath, 493, true);
                        }
                        if (!is_writable(dirname($imagePath))) {
                            $status = 401;
                            return Response::json(array(
                                "error" => 'Destination Unwritable'
                                ));
                        } else {
                            $oldpath = public_path("assets/images/profile-images/tmp/".Input::get('profile-image'));
                            $newpath = public_path("assets/images/profile-images/perm/".$final_path.'.'.$image_type);
                            rename($oldpath, $newpath);
                        }
                    }
                    if (Auth::attempt(array('username'=> $user->username, 'password'=>Input::get('password')))) {
                        $redirect = (Session::get('redirect')) ? Session::get('redirect') : null; 
                        
                        if(isset($redirect)) {
                            Flash::success('You have successfully been registered as '.$user->username.'!');
                            return Redirect::to(Session::get('redirect'));
                        } else {
                            Flash::success('You have successfully been registered as '.$user->username.'!');
                            //SESION DOESN'T EXIST
                            return redirect()->action('HomeController@postIndex');
                        }
                    }
                }
            }

        } else {
            // validation has failed, display error messages    
            return Redirect::back()
            ->with('message', 'The following errors occurred')
            ->with('alert_type','alert-danger')
            ->withErrors($validator)
            ->withInput();
        }

    }
    public function getLogin()
    {
        return view('users.login')
        ->with('layout',$this->layout);
    }
    public function postLogin()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        if (Auth::attempt(array('username'=>$username, 'password'=>$password))) {
            Flash::success('Welcome back '.$username.'!');
            return redirect()->action('HomeController@postIndex');
        } else { //LOGING FAILED
            if (isset($direct_login)) {
                return view('users.login')
                    ->with('layout',$this->layout)
                    ->with('wrong',1);
            } else {
                return view('users.login')
                    ->with('layout',$this->layout)
                    ->with('wrong',1); 
            }
        }
    }   
    public function postLoginModal()
    {
        $username = Input::get('username');
        $password = Input::get('password');
        if (Auth::attempt(array('username'=>$username, 'password'=>$password))) {
            $redirect = (Session::get('redirect_flash')) ? Session::get('redirect_flash') : null; 
            if(isset($redirect)) {
                Flash::success('Welcome back '.$username.'!');
                return Redirect::to($redirect);
            } else { //SESSION DOESN'T EXIST
                return redirect()->action('HomeController@postIndex');
            }
        } else { //LOGIN FAILED
            return view('users.login')
                ->with('layout',$this->layout)
                ->with('wrong',1); 
        }
    }
    public function getLogout()
    {
       
        if (Session::get('redirect_flash')) {
            $pre_path = Session::get('redirect_flash');
            Auth::logout();
            Session::reflash();
            switch ($pre_path) {
                case URL::to('/'):
                       return Redirect::action('HomeController@getIndex');
                    break;
                default:
                        return Redirect::action('HomeController@postIndex');
                    break;
            }
        } else {
            Auth::logout();
            return Redirect::action('HomeController@getIndex');
        }
    }
    public function postLogout()
    {
        Auth::logout();
        return Redirect::action('HomeController@getIndex');
    }

    public function getProfile($username)
    {
        if (Auth::user()->username == $username) {
            $categories_for_select = Category::prepareForSelect(Category::where('status',1)->get());
            $categories_for_side = Category::prepareForSide(Category::where('status',1)->get());
            $current_user = User::find(Auth::user()->id);
            $profile_image = Job::imageValidator($current_user->profile_image);
            $email = $current_user->email;
            $fname = $current_user->firstname;
            $lname = $current_user->lastname;
            return view('users.profile')
            ->with('layout',$this->layout)
            // ->with('threads',$prepared_thread)
            ->with('categories_for_select',$categories_for_select)
            ->with('categories_for_side',$categories_for_side)
            ->with('profile_image',$profile_image)        
            ->with('email',$email)
            ->with('fname',$fname)
            ->with('lname',$lname);
        } else {
            abort(404);
        }
    }
    public function postProfile()
    {
        $validator = Validator::make(Input::all(), User::updatevalidation());
        if ($validator->passes()) {
            $user = User::find(Auth::user()->id);
            $user->firstname = Input::get('fname');
            $user->lastname = Input::get('lname');
            if ($user->save()) {
                Flash::success('Profile Successfully Updated');
                return Redirect::action('UsersController@getProfile',$user->username);
            //     $redirect = (Session::get('redirect')) ? Session::get('redirect') : null; 
            //     if(isset($redirect)) {
            //        return Redirect::to(Session::get('redirect'));
            //    } else {
            //         //SESION DOESN'T EXIST
            //     return Redirect::to('/');
            // }
        }
    } else {
            // validation has failed, display error messages    
        return Redirect::back()
        ->with('message', 'The following errors occurred')
        ->with('alert_type','alert-danger')
        ->withErrors($validator)
        ->withInput();
    }
}

public function postValidate()
{
    $reg_form = null;
    parse_str(Input::get('reg_form'), $reg_form);
    $validation_results = Job::validate_data($reg_form);
    if(Request::ajax()){
        return Response::json(array(
            'status' => 200,
            'validation_callback' => $validation_results
            ));
    }
}

public function postUserAuth()
{
    if(Request::ajax()){
        $status = 400;
        if (Auth::check()) {
            $status = 200;
        }
        return Response::json(array(
            'status' => $status
            ));
    }
}

public function postSendFile()
{
    if(Request::ajax()){
        $status = 400;
        $imagePath = public_path("assets/images/profile-images/perm/");
        $imagename = $_FILES[0]['name'];
        $imagetemp = $_FILES[0]['tmp_name'];
        $image_ex = explode('.', $imagename);
        $image_type = $image_ex[1];
        $now_time = time();
        $new_imagename = $now_time . '-' . $imagename[0];
            // check if $folder is a directory
        if( ! \File::isDirectory($imagePath) ) {
                // Params:
                // $dir = name of new directory
                //
                // 493 = $mode of mkdir() function that is used file File::makeDirectory (493 is used by default in \File::makeDirectory
                //
                // true -> this says, that folders are created recursively here! Example:
                // you want to create a directory in company_img/username and the folder company_img does not
                // exist. This function will fail without setting the 3rd param to true
                // http://php.net/mkdir  is used by this function

            \File::makeDirectory($imagePath, 493, true);
        }
        if (!is_writable(dirname($imagePath))) {
            Job::dump('DIRECTORY IS NOT WRITEABLE');
            $status = 401;
            return Response::json(array(
                "error" => 'Destination Unwritable'
                ));
        } else {

            $final_path = preg_replace('#[ -]+#', '-', $new_imagename);

            if (move_uploaded_file($imagetemp, $imagePath . $final_path.'.'.$image_type)) {
                $status = 200;
                    //SAVE THE NEW IMAGE NAME INTO USERS TABLE
                $user = User::find(Auth::user()->id);
                    //DELETE USERS PREVIOUS IMAGE
                if ($user->profile_image != 'blank_male.png') {
                    $old_image = public_path("assets/images/profile-images/perm/".$user->profile_image);
                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }
                }

                $user->profile_image = $final_path.'.'.$image_type;
                $db_imagepath = null;
                if ($user->save()) {
                 $db_imagepath = $user->profile_image;
             }
             return Response::json(array(
                'status' => 'success',
                "image_name" => $new_imagename,
                "image_type" => $image_type
                ));
         }
     }
     return Response::json(array(
        'error' => 'error'
        ));
 }
}

public function postSendFileTemp()
{
    if(Request::ajax()){
            // $imagePath = "img/tmp/";
        $status = 400;
        $imagePath = public_path("assets/images/profile-images/tmp/");
        $imagename = $_FILES[0]['name'];
        $imagetemp = $_FILES[0]['tmp_name'];

        $image_ex = explode('.', $imagename);
        $image_type = $image_ex[1];

        $now_time = time();
        $new_imagename = $now_time . '-' . $imagename[0];
            // check if $folder is a directory
        if( ! \File::isDirectory($imagePath) ) {

                // Params:
                // $dir = name of new directory
                //
                // 493 = $mode of mkdir() function that is used file File::makeDirectory (493 is used by default in \File::makeDirectory
                //
                // true -> this says, that folders are created recursively here! Example:
                // you want to create a directory in company_img/username and the folder company_img does not
                // exist. This function will fail without setting the 3rd param to true
                // http://php.net/mkdir  is used by this function

            \File::makeDirectory($imagePath, 493, true);
        }
        if (!is_writable(dirname($imagePath))) {
            $status = 401;
            return Response::json(array(
                "error" => 'Destination Unwritable'
                ));
        } else {
            $final_path = preg_replace('#[ -]+#', '-', $new_imagename);
            if (move_uploaded_file($imagetemp, $imagePath . $final_path.'.'.$image_type)) {
                $status = 200;
                return Response::json(array(
                    'status' => 'success',
                    "image_name" => $new_imagename,
                    "image_type" => $image_type
                    ));
            }
        }
        return Response::json(array(
            'error' => 'error'
            ));

    }
}
public function postReturnUsers()
{
    if(Request::ajax()){
        $status = 400;
        if (Auth::check()) {
            $search = Input::get('search');
            $users = array();
            $status = 200;
            $message = 'Successfully found users!';
            if($search) {
                foreach ($search as $key => $value) {
                    $type = $key;
                    switch ($type) {
                        case 'name':
                        $first_name = $value['first_name'];
                        $last_name = $value['last_name'];
                        $users = User::where('firstname','LIKE','%'.$first_name.'%')
                            ->where('lastname','LIKE','%'.$last_name.'%')
                            ->get();

                        if(count($users) == 0){
                            $status = 401;
                            $message = 'No such name.';
                        }
                        break;
                        default:
                        foreach ($value as $column_name => $column_value) {
                            $users = User::where($column_name,'LIKE','%'.$column_value.'%')->get();
                        }

                        if(count($users) == 0) {
                            $status = 401;
                            $message = 'No such user';
                        }
                        break;
                    }
                }
            }

            $users_tbody = User::PrepareUsersData($users);
            return Response::json(array(
                'status' => $status,
                'message' => $message,
                'users_tbody'   => $users_tbody
                ));
        }
    }
}



}
