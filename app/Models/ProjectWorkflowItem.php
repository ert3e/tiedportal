<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectWorkflowItem extends Model
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

    public $timestamps = false;

    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function workflowItem() {
        return $this->belongsTo('App\Models\WorkflowItem');
    }

    public function parent() {
        return $this->belongsTo('App\Models\ProjectWorkflowItem', 'parent_id');
    }

    public function status() {
        return $this->belongsTo('App\Models\WorkflowItemStatus');
    }
}
