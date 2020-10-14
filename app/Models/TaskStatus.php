<?php

namespace App\Models;

use App\AppTraits\HasColour;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasColour;

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
        'name'          => ['name' => 'Name', 'type' => 'text'],
        'colour'        => ['name' => 'Colour', 'type' => 'colour'],
        'description'   => ['name' => 'Description', 'type' => 'textarea']
    ];

    public function displayName() {
        return $this->name;
    }
}
