<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $timestamps = false;

    public function componentable() {
        return $this->morphTo();
    }

    public function componentType() {
        return $this->belongsTo('App\Models\ComponentType');
    }

    public function values() {
        return $this->hasMany('App\Models\ComponentFieldValue');
    }

    public function fileCount() {

        $file_count = 0;
        foreach( $this->values as $value ) {
            if( $value->componentField->type == 'file' ) {
                $file_count++;
                break;
            }
        }

        return $file_count;
    }
}
