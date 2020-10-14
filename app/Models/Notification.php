<?php

namespace App\Models;

use App\AppTraits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasEvents;

    /**
    * Possible statuses for notifications
    * @var array
    */

    protected $statuses = [ 0 => 'New', 1 => 'Pending', 2 => 'Complited', -1 => 'Removed'];

    
    /**
    * Possible priorities for notifications
    * @var array
    */
    protected $prorities = [ 'Low', 'Medium', 'High' ];



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'status', 'priority'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function getStatusAttribute()
    {
        return $this->statuses[$this->attributes['status']];
    }
    
    public function getPriorityAttribute()
    {
        // dd($this->attributes['priority']);
        return $this->prorities[$this->attributes['priority']];
        
    }
}
