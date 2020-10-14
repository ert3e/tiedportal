<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectWorkflowItemStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function projectWorkflowItem() {
        return $this->belongsTo('App\Models\ProjectWorkflowItem');
    }

    public function workflowItemStatus() {
        return $this->belongsTo('App\Models\WorkflowItemStatus');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function note() {
        return $this->belongsTo('App\Models\Note');
    }
}
