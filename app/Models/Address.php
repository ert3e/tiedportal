<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address1', 'address2', 'town', 'county', 'postcode', 'country'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function asString($token = ', ') {

        $parts = array_filter([
            $this->address1,
            $this->address2,
            $this->town,
            $this->county,
            $this->postcode,
            $this->country
        ]);

        return implode($token, $parts);
    }
}
