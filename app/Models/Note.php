<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
