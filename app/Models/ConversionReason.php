<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversionReason extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $timestamps = false;

    public static $fields = [
        'name'          => ['name' => 'Name', 'type' => 'text'],
        'type'          => ['name' => 'Type', 'type' => 'select', 'values' => 'getValues', 'value' => 'getType'],
        'description'   => ['name' => 'Description', 'type' => 'textarea']
    ];

    public function scopeWon($query) {
        return $query->where('type', 'won');
    }

    public function scopeLost($query) {
        return $query->where('type', 'lost');
    }

    public static function getValues() {
        return [
            'won'       => 'Lead won',
            'lost'      => 'Lead lost'
        ];
    }

    public function getType() {
        return $this->type;
    }

    public function projects() {
        return $this->hasMany('App\Models\Project');
    }
}
