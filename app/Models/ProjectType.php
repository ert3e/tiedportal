<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'parent_id'
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
        'parent_id'     => ['name' => 'Parent', 'type' => 'select', 'values' => 'getRootValues', 'value' => 'getParent'],
        'description'   => ['name' => 'Description', 'type' => 'textarea']
    ];

    public static function getRootValues() {
        return [0 => '-- No parent --'] + ProjectType::where('parent_id', 0)->lists('name', 'id')->toArray();
    }

    public function getParent() {
        return is_object($this->parent) ? $this->parent->name : 'None';
    }

    public function children() {
        return $this->hasMany('App\Models\ProjectType', 'parent_id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\ProjectType', 'parent_id');
    }
}
