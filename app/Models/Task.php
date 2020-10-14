<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use App\AppTraits\HasNotes;
use App\Interfaces\NotifiesEvents;
use Illuminate\Database\Eloquent\Model;
use \Auth;

class Task extends Model implements NotifiesEvents
{
    use HasEvents;
    use HasNotes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'due_date', 'start_date', 'task_type_id', 'task_status_id', 'priority', 'status', 'private', 'description'
    ];

    protected $dates = ['start_date', 'due_date', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public static $priorities = [
        0       => 'Lowest',
        1       => 'Low',
        2       => 'Normal',
        3       => 'High',
        4       => 'Highest'
    ];

    // Public-visible field names
    public static $display_names = [
        'due_date'          => 'due date',
        'start_date'        => 'start date',
        'task_type_id'      => 'type',
        'task_status_id'    => 'status',
        'user_id'           => 'user',
        'parent_id'         => 'parent',
        'title'             => 'title',
        'description'       => 'description',
        'status'            => 'status'
    ];

    // Mapping ID columns to classes
    // These are used by TimelineRenderer to display
    // meaningful values when ID columns change.
    public static $property_map = [
        'task_type_id'      => 'App\Models\TaskType',
        'task_status_id'    => 'App\Models\TaskStatus',
        'user_id'           => 'App\Models\User',
        'parent_id'         => 'App\Models\Task',
        'status'            => ['open' => 'Open', 'closed' => 'Closed'],
        'priority'          => ['Lowest', 'Low', 'Normal', 'High', 'Highest']
    ];

    // Static rules apply to new objects
    public static $rules = [
        'start_date'    => 'date_format:d/m/Y',
        'due_date'      => 'date_format:d/m/Y'
    ];

    // Class rules apply to new objects
    public function rules() {
        return self::$rules;
    }

    public function displayName() {
        return $this->title;
    }

    public function notifyUsers() {
        return ['user', 'assignees'];
    }

    public function scopeVisible($query) {
        return $query->where(function($query) {
            $query->where("private", 0);
            $query->orWhere('user_id', Auth::user()->id);
            $query->orWhereHas('assignees', function($q) {
                $q->where('id', Auth::user()->id);
            });
        });
    }

    public function scopeOpen($query) {
        return $query->visible()->where('status', 'open');
    }

    public function scopeCompleted($query) {
        return $query->visible()->where('task_status_id', 5);
    }

    public function scopeUncompleted($query) {
        return $query->visible()->where('task_status_id','<>', 5);
    }

    public function scopeAssigned($query, $owner = null) {
        if(!$owner){
            $owner = Auth::user()->id;
        }
        return $query->whereHas('assignees', function($q) use ($owner) {
            $q->where('id', $owner);
        });
    }

    public function scopeMine($query) {
        return $query->where('user_id', Auth::user()->id);
    }

    public function scopeClosed($query) {
        return $query->visible()->where('status', 'closed');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function assignees() {
        return $this->belongsToMany('App\Models\User', 'task_user');
    }

    public function parent() {
        return $this->belongsTo('App\Models\Task', 'parent_id');
    }

    public function children() {
        return $this->hasMany('App\Models\Task', 'parent_id', 'id');
    }

    public function hasTaskable() {
        return !empty($this->taskable_type);
    }

    public function taskable() {
        return $this->morphTo();
    }

    public function getProjectAttribute() {
        if( $this->hasTaskable() && is_a($this->taskable, Project::class) )
            return $this->taskable;
        return null;
    }

    public function taskType() {
        return $this->belongsTo('App\Models\TaskType');
    }

    public function taskStatus() {
        return $this->belongsTo('App\Models\TaskStatus');
    }

    public function notes() {
        return $this->belongsToMany('App\Models\Note');
    }

    public function attachments() {
        return $this->belongsToMany('App\Models\Media', 'media_task');
    }

    public function getVerbalPriorityAttribute() {
        // return 'test';
        // return Task::$priorities[0];
        return Task::$priorities[$this->attributes['priority']];
    }
}
