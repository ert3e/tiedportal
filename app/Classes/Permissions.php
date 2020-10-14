<?php

namespace App\Classes;

use \Auth;
use \Config;

class Permissions
{
    private $permission_keys;

    function __construct() {
        $this->permission_keys = array_flip(Config::get('permissions'));
    }

    public function has($groups, $permissions) {

        if( !Auth::check() )
            return false;

        $user = Auth::user();

        // System admin has all access regardless of role (doesn't have role)
        if( $user->system_admin ) {
            return true;
        }

        $role = $user->role;

        if( is_array($groups) ) {

            $has_permission = true;

            foreach( $groups as $group ) {
                if (is_object($role) && array_key_exists($permissions, $this->permission_keys)) {
                    $has_permission = ($has_permission && $role->has($group, $this->permission_keys[$permissions]));
                }
            }

            return $has_permission;

        } else {

            if (is_object($role) && array_key_exists($permissions, $this->permission_keys)) {
                return $role->has($groups, $this->permission_keys[$permissions]);
            }
        }

        return false;
    }
}
