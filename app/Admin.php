<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Job;
use App\RoleUser;
use App\User;
class Admin extends Model
{
    public static $add_roles = array(
        'role-title'=>'required',
        'role-slug'=>'required'
    );
    public static $add_permission = array(
        'permission-title'=>'required',
        'permission-slug'=>'required',
        'permission-description'=>'required'
    );

    public static $add_permission_role = array(
        'permission_id'=>'required',
        'role_id'=>'required'
    );

    public static function getApprovedAdmins() {
        $admins = [''=>'Select Administrator'];
        $roles = 2; //Anything below this number we will allow to set tasks
        $approved = RoleUser::where('role_id', '<=', $roles)->get();
        if($approved) {
            foreach ($approved as $a) {
                $user_id = $a->user_id;
                $users = User::find($user_id);
                $admins[$user_id] = $users->username;
            }
        }

        return $admins;
    }
        public static function getRoleName($id)
    {
        switch($id) {
            case 1: // Superadmin
            $role = 'Superadmins';
            break;
            case 2: // Admin
            $role = 'Admins';
            break;
            case 3:
            $role = 'Owners';
            break;
            case 4: // Employee
            $role = 'Employees';
            break;
            case 5: // Member
            $role = 'Members';
            break;
            default: // Guest
            $role = 'Guests';
            break;
        }
        return $role;
    }

    public static function checkAuthorized($controller, $method, $params)
    {
        $user_id = Auth::user()->id;
        $role_id = Auth::user()->roles;
        $authorized = true;

        if(Acl::isAllowed(Admin::getRoleName($role_id), $controller, $method) == false) {
            $authorized = false;
            
        }

        return $authorized;
    }
    public static function roles()
    {
        $roles = array(
            '' => 'Select Administrator Type',
            2 => 'Admin',
            3 => 'Employee',
            4 => 'Member',
        );
        return $roles;
    }
}