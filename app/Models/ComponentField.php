<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentField extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $timestamps = false;

    public function componentType() {
        return $this->belongsTo('App\Models\ComponentType');
    }
}
