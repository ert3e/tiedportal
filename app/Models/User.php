<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role_id', 'type', 'last_login'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Static rules apply to new objects
    public static $rules = [
        'email'         => 'required|email|unique:users,email',
        'username'      => 'required|unique:users,username',
        'role_id'       => 'exists:roles,id'
    ];

    // Class rules apply to new objects
    public function rules() {
        return [
            'email'         => 'required|email|unique:users,email,' . $this->id,
            'username'      => 'required|unique:users,username,' . $this->id,
            'role_id'       => 'exists:roles,id'
        ];
    }

    public function scopeEmail($query, $email) {
        return $query->where('email', 'LIKE', $email);
    }

    public function scopeUser($query) {
        return $query->where('type', 'user');
    }

    public function scopeSupplier($query) {
        return $query->where('type', 'supplier');
    }

    public function scopeCustomer($query) {
        return $query->where('type', 'customer');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media');
    }

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    public function getCustomerAttribute() {
        return $this->contact->customer;
    }

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }

    public function quoteRequests() {
        return $this->hasMany('App\Models\QuoteRequest');
    }

    public function getSupplierAttribute() {
        return is_object($this->contact) ? $this->contact->supplier : null;
    }

    public function contact() {
        return $this->hasOne('App\Models\Contact');
    }

    public function tickets() {
        return $this->hasMany('App\Models\Ticket');
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

    public function events() {
        return $this->hasMany('App\Models\Event')->orderBy('date', 'DESC');
    }

    public function notifications() {
        return $this->hasMany('App\Models\Notification')->orderBy('priority', 'DESC');
    }

    public function displayName() {
        if( is_object($this->contact) )
            return sprintf('%s %s', $this->contact->first_name, $this->contact->last_name);

        return $this->username;
    }
}
