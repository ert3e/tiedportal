<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'invoiced', 'description', 'cost'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    // Public-visible field names
    public static $display_names = [
        'invoiced'  => 'invoiced'
    ];

    // Mapping ID columns to classes
    // These are used by TimelineRenderer to display
    // meaningful values when ID columns change.
    public static $property_map = [
        'invoiced'  => ['No', 'Yes']
    ];

    public function scopeForProjects($query, $project_ids) {
        return $query->whereIn('project_id', $project_ids);
    }

    public function getDates() {
        return parent::getDates() + ['invoice_date'];
    }

    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function quote() {
        return $this->belongsTo('App\Models\Quote');
    }
}
