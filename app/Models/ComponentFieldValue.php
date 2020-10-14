<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentFieldValue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $timestamps = false;

    public function component() {
        return $this->belongsTo('App\Models\Component');
    }

    public function componentField() {
        return $this->belongsTo('App\Models\ComponentField');
    }
}
