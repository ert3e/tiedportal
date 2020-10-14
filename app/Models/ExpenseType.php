<?php

namespace App\Models;

use App\AppTraits\HasColour;
use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    use HasColour;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'colour', 'description'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public static $fields = [
        'name'          => ['name' => 'Name', 'type' => 'text'],
        'colour'        => ['name' => 'Colour', 'type' => 'colour'],
        'description'   => ['name' => 'Description', 'type' => 'textarea']
    ];
}
