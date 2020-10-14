<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
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
        'name' => ['name' => 'Name', 'type' => 'text'],
        'description' => ['name' => 'Description', 'type' => 'textarea']
    ];

    public function displayName() {
        return $this->name;
    }
}
