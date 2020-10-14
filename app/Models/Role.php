<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    public $timestamps = false;

    public function permissions() {
        return $this->hasMany('App\Models\Permission');
    }

    public function has($group, $permission) {
        $permission_obj = $this->permissions()->where('key', $group)->first();

        if( is_object($permission_obj) ) {
            return $permission_obj->has($permission);
        }

        return false;
    }

    public function displayName() {
        return $this->name;
    }
}
