<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use App\AppTraits\HasNotes;
use App\AppTraits\HasTasks;
use App\Interfaces\NotifiesEvents;
use Illuminate\Database\Eloquent\Model;
use \Auth;

class Project extends Model implements NotifiesEvents
{
    use HasEvents;
    use HasTasks;
    use HasNotes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'start_date', 'due_date', 'customer_id', 'contact_id', 'type', 'user_id', 'types', 'parent_id', 'status', 'project_status_id', 'prospect_status_id', 'lead_source_details', 'lead_source_id', 'value', 'scope'
    ];

    protected $dates = ['start_date', 'due_date', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    // Public-visible field names
    public static $display_names = [
        'due_date'          => 'due date',
        'start_date'        => 'start date',
        'type'              => 'type',
        'status'            => 'status',
        'name'              => 'name',
        'lead_source_id'    => 'lead source',
        'customer_id'       => 'customer',
        'contact_id'        => 'contact',
        'parent_id'         => 'parent',
        'project_status_id' => 'project status',
        'prospect_status_id'=> 'prospect status',
        'description'       => 'description'
    ];

    // Mapping ID columns to classes
    // These are used by TimelineRenderer to display
    // meaningful values when ID columns change.
    public static $property_map = [
        'customer_id'       => 'App\Models\Customer',
        'contact_id'        => 'App\Models\Contact',
        'user_id'           => 'App\Models\User',
        'parent_id'         => 'App\Models\Project',
        'project_status_id' => 'App\Models\ProjectStatus',
        'lead_source_id'    => 'App\Models\LeadSource',
        'prospect_status_id'=> 'App\Models\ProspectStatus'
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

    public function notifyUsers() {
        return ['assignees'];
    }

    protected function getLinkedEventModels() {
        return ['children', 'components', 'notes', 'costs'];
    }

    public function displayName() {
        if( is_object($this->customer) )
            return sprintf('%s / %s', $this->customer->name, $this->name);
        return $this->name;
    }

    public function scopeAssigned($query) {
        return $query->whereHas('assignees', function($q) {
            $q->where('id', Auth::user()->id);
        });
    }

    public function scopeMine($query) {
        return $query->where('user_id', Auth::user()->id);
    }

    public function scopeActive($query) {
        return $query->where('status', 'active');
    }

    public function scopeLost($query) {
        return $query->where('status', 'lost');
    }

    public function scopeUncomplete($query) {
        return $query->where('status', '<>', 'complete');
    }

    public function scopeComplete($query) {
        return $query->where('status', 'complete');
    }

    public function scopeProspects($query) {
        return $query->where('status', 'prospect');
    }

    public function scopeProjects($query) {
        return $query->where('status', 'active');
    }

    public function scopeConverted($query) {
        return $query->whereNotNull('conversion_date');
    }

    public function scopeUnconverted($query) {
        return $query->whereNull('conversion_date');
    }

    public function scopeExternal($query) {
        return $query->where('scope','external');
    }

    public function components() {
        return $this->morphMany('App\Models\Component', 'componentable')->orderBy('id', 'DESC');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function projectStatus() {
        return $this->belongsTo('App\Models\ProjectStatus');
    }

    public function prospectStatus() {
        return $this->belongsTo('App\Models\ProspectStatus');
    }

    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }

    public function contact() {
        return $this->belongsTo('App\Models\Contact', 'contact_id');
    }

    public function assignees() {
        return $this->belongsToMany('App\Models\User', 'project_user');
    }

    public function leadSource() {
        return $this->belongsTo('App\Models\LeadSource');
    }

    public function suppliers() {
        return $this->belongsToMany('App\Models\Supplier');
    }

    public function parent() {
        return $this->belongsTo('App\Models\Project', 'parent_id');
    }

    public function children() {
        return $this->hasMany('App\Models\Project', 'parent_id', 'id');
    }

    public function types() {
        return $this->belongsToMany('App\Models\ProjectType');
    }

    public function quotes() {
        return $this->hasMany('App\Models\Quote')->orderBy('created_at', 'DESC');
    }

    public function costs() {
        return $this->hasMany('App\Models\Cost')->orderBy('created_at', 'DESC');
    }

    public function quoteRequests() {
        return $this->hasMany('App\Models\QuoteRequest')->orderBy('created_at', 'DESC');
    }

    public function getDates() {
        return parent::getDates() + ['start_date', 'due_date'];
    }

    public function notes() {
        return $this->belongsToMany('App\Models\Note');
    }

    public function bills() {
        return $this->hasMany('App\Models\Bill');
    }

    public function attachments() {
        return $this->belongsToMany('App\Models\Media', 'media_project');
    }

    public function tasks() {
        return $this->morphMany('App\Models\Task', 'taskable')->visible();
    }
}
