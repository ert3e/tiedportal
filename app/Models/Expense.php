<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recurring_period', 'recurring_unit', 'amount', 'start_date', 'end_date', 'name', 'description'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function getDates() {
        return parent::getDates() + ['start_date', 'end_date'];
    }

    public function type() {
        return $this->belongsTo('App\Models\ExpenseType');
    }

    public function projects() {
        return $this->belongsToMany('App\Models\Project');
    }

    public function suppliers() {
        return $this->belongsToMany('App\Models\Supplier');
    }
}
