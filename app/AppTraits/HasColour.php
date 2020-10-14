<?php namespace App\AppTraits;

use Illuminate\Http\Request;
use App\Models\Media;

trait HasColour
{
    public function setColourAttribute($value) {
        $this->attributes['colour'] = trim($value, ' #');
    }
}