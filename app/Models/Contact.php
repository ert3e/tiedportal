<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'telephone', 'mobile', 'email', 'description', 'contact_type_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    // Static rules apply to new objects
    public static $rules = [
        'first_name'    => 'required',
        'type_id'       => 'exists:contact_types,id'
    ];

    // Class rules apply to new objects
    public function rules() {
        return self::$rules;
    }

    public function scopeEmail($query, $email) {
        return $query->where('email', 'LIKE', $email);
    }

    public function media() {
        return $this->belongsTo('App\Models\Media');
    }

    public function contactType() {
        return $this->belongsTo('App\Models\ContactType', 'contact_type_id');
    }

    public function customers() {
        return $this->belongsToMany('App\Models\Customer');
    }

    public function suppliers() {
        return $this->belongsToMany('App\Models\Supplier');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function getSupplierAttribute() {
        return $this->suppliers->first();
    }

    public function getCustomerAttribute() {
        return $this->customers->first();
    }


    public function getTypeAttribute() {
            return ContactType::find($this->attributes['contact_type_id']);
    }


    public function asString($token = ' / ') {

        $parts = array_filter([
            $this->telephone,
            $this->mobile
        ]);

        return implode($token, $parts);
    }

    public function imageUrl($width = 40, $height = 40) {

        if( is_object($this->media) ) {
            return  route('media.get', [$this->media_id, $width, $height]);
        }

        // Fallback to Gravatar
        $default = 'mm';
        $grav_url = "//www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?d=" . urlencode($default) . "&s=" . $width;

        return $grav_url;
    }

    public function displayName() {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }
}
