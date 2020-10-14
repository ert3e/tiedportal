<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'severity', 'subject', 'project_id', 'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public static $severity_levels = [
        'Low',
        'Normal',
        'Severe',
        'Critical'
    ];

    public function getContentAttribute() {
        return $this->notes()->orderBy('created_at', 'ASC')->first()->content;
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }

    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function notes() {
        return $this->belongsToMany('App\Models\Note');
    }

    public function attachments() {
        return $this->belongsToMany('App\Models\Media', 'media_ticket');
    }
}
