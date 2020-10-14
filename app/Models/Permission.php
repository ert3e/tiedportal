<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $timestamps = false;

    public function reset() {
        $this->mask = 0;
    }

    public function set($permission, $on = true) {
        if( $on ) {
            $this->mask = ($this->mask | $permission);
        } else {
            $this->mask = ($this->mask | ~$permission);
        }
    }

    public function has($permission) {
        return ($this->mask & $permission);
    }
}
