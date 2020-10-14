<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'description', 'amount', 'issue_date', 'due_date'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function getDates() {
        return parent::getDates() + ['issue_date', 'due_date'];
    }

    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function status() {
        return $this->belongsTo('App\Models\InvoiceStatus');
    }

    public function type() {
        return $this->belongsTo('App\Models\InvoiceType');
    }
}
