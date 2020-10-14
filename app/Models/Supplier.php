<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\AppTraits\HasEvents;

class Supplier extends Model
{
    use HasEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'projectTypes', 'website'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected function getLinkedEventModels() {
        return ['contacts', 'addresses'];
    }

    public function scopeVerified($query) {
        return $query->where('verified', true);
    }

    public function scopeUnverified($query) {
        return $query->where('verified', false);
    }

    public function primaryContact() {
        return $this->belongsTo('App\Models\Contact');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media');
    }

    public function contacts() {
        return $this->belongsToMany('App\Models\Contact')->orderByRaw(\DB::raw(sprintf("FIELD(id, %d)", $this->primary_contact_id)));
    }

    public function addresses() {
        return $this->belongsToMany('App\Models\Address');
    }

    public function projectTypes() {
        return $this->belongsToMany('App\Models\ProjectType');
    }

    public function verifiedBy() {
        return $this->belongsTo('App\Models\User', 'verified_by');
    }

    public function quoteRequests() {
        return $this->hasMany('App\Models\QuoteRequest');
    }

    public function projects() {
        return $this->belongsToMany('App\Models\Project');
    }

    public function bills() {
        return $this->hasMany('App\Models\Bill');
    }

    public function imageUrl($width = 40, $height = 40) {

        if( is_object($this->media) ) {
            return  route('media.get', [$this->media_id, $width, $height]);
        }

        // Fallback to default
        return "/img/generic-supplier.png";
    }
}
