<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'colour'
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
        'colour'        => ['name' => 'Colour', 'type' => 'colour'],
        'name'          => ['name' => 'Name', 'type' => 'text'],
        'description'   => ['name' => 'Description', 'type' => 'textarea']
    ];

    public function displayName() {
        return $this->name;
    }
}
