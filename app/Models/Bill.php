<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'date', 'due_date', 'paid_date', 'amount'
    ];

    protected $dates = ['date', 'due_date', 'paid_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function scopeUnpaid($query) {
        return $query->whereNull('paid_date');
    }

    public function scopePaid($query) {
        return $query->whereNotNull('paid_date');
    }
    
    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media');
    }
}
