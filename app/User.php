<?php

namespace App;

use Auth;
use App\Job;
use App\User;
use App\Admin;
use App\Role;
use App\RoleUser;
use App\Permission;
use App\PermissionRole;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;





class User extends Model implements
AuthenticatableContract, CanResetPasswordContract
{
      use Authenticatable, CanResetPassword, SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    public static $registration = array(
        'email'=>'required|email|unique:users',
        'password'=>'required|between:6,25|',
        'password_again'=>'required|between:6,25'
    );


    public static $rules_password_reset = array(
        'email'=>'required|email|unique:users',
        'password'=>'required|between:6,25|',
        'password_confirmation'=>'required|between:6,25'
    );

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'username', 'email', 'password'];

    /*
    |--------------------------------------------------------------------------
    | ACL Methods
    |--------------------------------------------------------------------------
    */
public static $rules_add = array(
        'username'=>'required|alpha_num|min:4|unique:users',
        'roles'=>'required',
        'firstname'=>'required|alpha|min:2',
        'lastname'=>'required|alpha|min:2',
        'email'=>'required|email|unique:users',
        'password'=>'required|between:6,25|confirmed',
        'password_confirmation'=>'required|between:6,25'
        );
    public static $rules_edit = array(
        'username'=>'required|alpha_num|min:4|unique:users',
        'roles'=>'required',
        'firstname'=>'required|alpha|min:2',
        'lastname'=>'required|alpha|min:2',
        'email'=>'required|email',
        'password'=>'required|between:6,25|confirmed',
        'password_confirmation'=>'required|between:6,25'
        );
    public static $rules_not_password_alt = array(
        'username'=>'required|alpha_num|min:4|unique:users',
        'roles'=>'required',
        'firstname'=>'required|alpha|min:2',
        'lastname'=>'required|alpha|min:2',
        'email'=>'required|email'
        );
    public static $rules_edit_name = array(
        'username'=>'required|alpha_num|min:4',
        'roles'=>'required',
        'firstname'=>'required|alpha|min:2',
        'lastname'=>'required|alpha|min:2',
        'email'=>'required|email',
        'password'=>'required|between:6,25|confirmed',
        'password_confirmation'=>'required|between:6,25'
        );
    public static $rules_not_password = array(
        'username'=>'required|alpha_num|min:4',
        'roles'=>'required',
        'firstname'=>'required|alpha|min:2',
        'lastname'=>'required|alpha|min:2',
        'email'=>'required|email'
        );
    public static $rules = array(
        'username'=>'required|alpha_num|min:4|unique:users',
        'firstname'=>'required|alpha|min:2',
        'lastname'=>'required|alpha|min:2',
        'email'=>'required|email|unique:users',
        'password'=>'required|between:6,25|confirmed',
        'password_confirmation'=>'required|between:6,25'
        );
    public static $edit_rules = array(
        'username'=>'required|alpha_num|min:4',
        'firstname'=>'required|alpha|min:2',
        'lastname'=>'required|alpha|min:2',
        'email'=>'required|email',
        'password'=>'between:6,25|confirmed',
        'password_confirmation'=>'between:6,25'
        );
    public static $rules_reset = array(
        'email'=>'required|email',
        'password'=>'required|between:6,25|confirmed',
        'password_confirmation'=>'required|between:6,25'
        );

    public static function prepare($data){
        if(isset($data)){
            foreach ($data as $key => $value) {
                if(isset($data[$key]['roles'])) {
                    switch ($data[$key]['roles']) {
                        case 1:// Super Admin
                        $data[$key]['roles_formated'] = '<span class="label label-primary">Super Admin</span>';
                        break;
                        case 2:// Admin
                        $data[$key]['roles_formated'] = '<span class="label label-primary">Admin</span>';
                        break;
                        case 3:// Employee
                        $data[$key]['roles_formated'] = '<span class="label label-info">Employee</span>';
                        break;
                        case 4:// Member
                        $data[$key]['roles_formated'] = '<span class="label label-info">Member</span>';
                        break;
                        default://errors
                        $data[$key]['roles_formated'] = '<span class="label label-danger">Error</span>';
                        break;
                    }
                }

            }
        }
        return $data;
    }

    public static function getOwnerId($member_id) {
        $owner_id = (isset($member_id)) ? (isset(Auth::user()->parent_id)) ? Auth::user()->parent_id : Auth::user()->id : null;
        return $owner_id;
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
    * ACL
    */
    /**
     * Returns role of the user
     * @return string
     */
    public function getRoleId()
    {
        return $this->role;
    }

    /**
    * Public methods
    **/
    public static function prepareForSelect($data) {
        $users = array(''=>'Select an employee');
        if(isset($data)) {
            foreach ($data as $key => $value) {
                $id = $value['id'];
                $username = $value['username'];
                $first_name = $value['firstname'];
                $last_name = $value['lastname'];
                $users[$id] = $username.' ['.$first_name.' '.$last_name.']';
            }
        }

        return $users;
    }

    public static function prepareForView($data) {

        if(isset($data['phone'])) {
            $data['country'];
            $data['phone'] = Job::format_phone($data['phone'], $data['country']);
        }

        if(isset($data['billing_type'])) {
            $data['billing_type_display'] = ($data['billing_type'] == false) ? 'Automatic payments are not set.' : 'Automatic payments are set.';
        } else {
            $data['billing_type'] = false;
            $data['billing_type_display'] = 'Automatic payments are not set.';
        }
        return $data;
    }

    public static function prepareForDeliveryTable($data) {
        $html = '';
        if(isset($data)) {
            foreach ($data as $key => $value) {
                $html .= '<tr class="table-tr" style="cursor:pointer">';
                $html .= '<td>'.$value->id.'</td>';
                $html .= '<td>'.$value->username.'</td>';
                $html .= '<td>'.$value->firstname.'</td>';
                $html .= '<td>'.$value->lastname.'</td>';
                $html .= '<td>'.Job::format_phone($value->phone, "US").'</td>';
                $html .= '<td>'.$value->email.'</td>';
                $html .= '<td><input class="checkUser" type="checkbox" value="'.$value->id.'"/> Select</td>';
                $html .= '</tr>';
            }
        }

        return $html;
    }
    /**
     * Checks a Permission
     *
     * @param  String permission Slug of a permission (i.e: manage_user)
     * @return Boolean true if has permission, otherwise false
     */
    public function can($permission = null)
    {


        return !is_null($permission) && $this->checkPermission($permission);

    }

    /**
     * Check if the permission matches with any permission user has
     *
     * @param  String permission slug of a permission
     * @return Boolean true if permission exists, otherwise false
     */
    protected function checkPermission($perm)
    {
        $grant_access = false;
        $permissions = $this->getUserPermission(); // Returns a list of permission slugs for the specified user role
        $permissionArray = is_array($perm) ? $perm : [$perm]; // Returns uri of current page as an array
        foreach ($permissionArray as $uri) {
            if($permissions) {
                foreach ($permissions as $p) {
                    if($uri == $p) {
                        $grant_access = true;
                        break;
                    }
                }
            }
        }
    
        return $grant_access;
    }

    /**
     * Get all permission slugs from all permissions of all roles
     *
     * @return Array of permission slugs
     */
    protected function getUserPermission()
    {
        $permissions = [];
        //GET USER ID
        $this_user_id = Auth::user()->id;
        //GET USER ROLE
        
        $this_role = RoleUser::find($this_user_id);  
        $permission_role = PermissionRole::where('role_id',$this_role->role_id)->get();
        if($permission_role){
            foreach ($permission_role as $pr_key => $pr_value) {
                $_permission = Permission::find($pr_value->permission_id);
                $permissions[$pr_key] = $_permission->permission_slug;

            }  
        }

        // return $permissions?$permissions->permission_slug:false;
        return $permissions;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */
   
    /**
     * Many-To-Many Relationship Method for accessing the User->roles
     *
     * @return QueryBuilder Object
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */


    static public function updateValidation() {
        $current_user = Auth::user()->id;
            return $update = array(
                'email'=>'',
                'fname'=>'required|alpha|min:2',
                'lname'=>'required|alpha|min:2'
             );
        }

    static public function CheckForProfileImage() {
            $data = 'empty';
            if (Auth::check()) {
                $this_user = User::find(Auth::user()->id);
                $data = Job::imageValidator($this_user->profile_image);
            } else {
                $data = Job::imageValidator($data);
            }
            return $data;
        }


    public static function search_by() {
            return array(
                ''          => 'Search users by',
                'id'        => 'user id',
                'username'  => 'username',
                'email'     => 'email',
                'name'      => 'full name'
                );
        }

    public static function PrepareUsersData($data) {
        $html = '';
        if(isset($data)) {
            foreach ($data as $key => $value) {
                $html .= '<tr class="table-tr" style="cursor:pointer">';
                $html .= '<td>'.$value->id.'</td>';
                $html .= '<td>'.$value->username.'</td>';
                $html .= '<td>'.$value->firstname.'</td>';
                $html .= '<td>'.$value->lastname.'</td>';
                $html .= '<td>'.$value->email.'</td>';
                $html .= '<td><a href="'.route("users_edit",$value->id).'">Edit</a></td>';
                $html .= '</tr>';
            }
        }

        return $html;
    }
}
