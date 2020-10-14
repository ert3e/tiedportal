<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowItem extends Model
{
    use HasEvents;

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

    public function workflow() {
        return $this->belongsTo('App\Models\Workflow');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media');
    }
}
