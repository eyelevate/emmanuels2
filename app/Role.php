<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }


    public static function PerpareAllForSelect() {
        $data = Role::get();
        
        $roles = array(''=>'Select Role');
        $roles['-999'] = 'All';
        if(isset($data)) {
            foreach ($data as $key => $value) {
                
                $roles_id = $value['id'];
                $roles_title = $value['role_title'];
                $roles[$roles_id] = $roles_title; 
            }

        }
        return $roles;
    }
    public static function PerpareAdminRoleSelect() {
        $data = Role::get();
        
        $roles = [];
        if(isset($data)) {
            foreach ($data as $key => $value) {
                
                $roles_id = $value['id'];
                $roles_title = $value['role_title'];
                $roles[$roles_id] = $roles_title; 
            }

        }
        return $roles;
    }
}