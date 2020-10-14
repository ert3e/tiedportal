<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 23/02/2016
 * Time: 13:11
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class EventRenderer extends Facade
{
    protected static function getFacadeAccessor() { return 'eventrenderer'; }
}