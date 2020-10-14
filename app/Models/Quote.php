<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'cost', 'includes_vat', 'message'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function status() {
        return $this->belongsTo('App\Models\QuoteStatus');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function quoteRequest() {
        return $this->belongsTo('App\Models\QuoteRequest');
    }

    public function media() {
        return $this->belongsToMany('App\Models\Media');
    }
}
