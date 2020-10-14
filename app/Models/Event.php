<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'event_class', 'metadata'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $dates = ['date'];

    public $timestamps = false;

    public function eventable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function setMetadataAttribute($value) {
        $this->attributes['metadata'] = json_encode($value);
    }

    public function getMetadataAttribute() {
        return json_decode($this->attributes['metadata']);
    }

    public static function boot() {
        parent::boot();

        self::creating(function($object) {
            $object->date = Carbon::now();
        });
    }
}
