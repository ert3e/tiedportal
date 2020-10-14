<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Breadcrumbs;
use \Config;
use \DB;

class RoleController extends Controller
{
    function __construct() {
        parent::__construct();
        Breadcrumbs::push(trans('settings.title'), route('settings.index'));
        Breadcrumbs::push(trans('roles.title'), route('roles.index'));
    }

    public function index() {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request) {

        $rules = [
            'name'  => 'required|unique:roles,name'
        ];

        $this->validate($request, $rules);

        $role = Role::create($request->only('name', 'description'));

        return redirect()->route('roles.details', $role->id);
    }

    public function delete($role) {
        $role->delete();
        return redirect()->route('roles.index');
    }

    public function details($role) {
        Breadcrumbs::push($role->name, route('roles.details', $role->id));
        $permissions_groups = Config::get('permissiongroups');
        $permissions = Config::get('permissions');
        return view('roles.details', compact('role', 'permissions_groups', 'permissions'));
    }

    public function update(Request $request, $role) {

        $permissions_groups = array_keys(Config::get('permissiongroups'));
        $permission_settings = $request->input('permission',[]);

        DB::transaction(function() use($role, $permissions_groups, $permission_settings) {

            // First we reset all the permissions
            foreach( $permissions_groups as $permission_group ) {
                $permission = $role->permissions()->where('key', $permission_group)->first();

                if( !is_object($permission) ) {
                    $permission = Permission::create([
                        'key'   => $permission_group
                    ]);
                    $role->permissions()->save($permission);
                }

                $permission->reset();

                $permission_objects[$permission_group] = $permission;
            }

            foreach( $permissions_groups as $permission_group ) {
                $permission = $permission_objects[$permission_group];

                if( array_key_exists($permission_group, $permission_settings) ) {
                    foreach ($permission_settings[$permission_group] as $bit) {
                        $permission->set($bit);
                    }
                }

                $permission->save();
            }
        });

        return redirect()->back()->with('success', 'Role saved successfully!');
    }
}
