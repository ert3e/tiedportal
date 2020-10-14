<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use App\Interfaces\NotifiesEvents;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model implements NotifiesEvents
{
    use HasEvents;

    function __construct(array $attributes = array()) {
        parent::__construct($attributes);

        $this->object_type = 'quote';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'message', 'supplier_message'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function notifyUsers() {
        return ['user', 'contact'];
    }

    public function scopePending($query) {
        return $query->where('status', 'pending');
    }

    public function scopeSubmitted($query) {
        return $query->where('status', 'submitted');
    }

    public function scopeDeclined($query) {
        return $query->where('status', 'declined');
    }

    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function contact() {
        return $this->supplier->primaryContact();
    }

    public function components() {
        return $this->belongsToMany('App\Models\Component');
    }
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function quotes() {
        return $this->hasMany('App\Models\Quote')->orderBy('created_at', 'DESC');
    }

    public function notes() {
        return $this->belongsToMany('App\Models\Note');
    }

    public function displayName() {
        return $this->project->name;
    }

    public function totalCost() {
        return $this->quotes()->sum('cost');
    }
}
