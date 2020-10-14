<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use App\Relations\HasManyThroughBelongsTo;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type_id', 'type', 'website'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $dates = ['updated_at', 'created_at', 'conversion_date'];

    protected function getLinkedEventModels() {
        return ['contacts', 'projects', 'addresses'];
    }

    // Static rules apply to new objects
    public static $rules = [
        'name'          => 'required',
        'type_id'       => 'exists:customer_types,id'
    ];

    // Class rules apply to new objects
    public function rules() {
        return self::$rules;
    }

    public function scopeLeads($query) {
        return $query->where('type', 'lead');
    }

    public function scopeCustomers($query) {
        return $query->where('type', 'customer');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media');
    }

    public function category() {
        return $this->belongsTo('App\Models\CustomerType');
    }

    public function contacts() {
        return $this->belongsToMany('App\Models\Contact');
    }

    public function projects() {
        return $this->hasMany('App\Models\Project')->where('status', 'active');
    }

    public function prospects() {
        return $this->hasMany('App\Models\Project')->where('status', 'prospect');
    }

    public function complete() {
        return $this->hasMany('App\Models\Project')->where('status', 'complete');
    }

    public function lost() {
        return $this->hasMany('App\Models\Project')->where('status', 'lost');
    }

    public function notes() {
        return $this->belongsToMany('App\Models\Note');
    }

    public function addresses() {
        return $this->belongsToMany('App\Models\Address');
    }

    public function attachments() {
        return $this->belongsToMany('App\Models\Media', 'customer_media');
    }

    public function imageUrl($width, $height) {
        if( is_object($this->media) )
            return route('media.get', [$this->media_id, $width, $height]);

        return '/img/generic-customer.png';
    }
}
