<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowItemAction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'handler', 'metadata'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $timestamps = false;
}
