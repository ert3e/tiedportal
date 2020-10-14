<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 25/01/2016
 * Time: 07:55
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class Settings extends Facade
{
    protected static function getFacadeAccessor() { return 'settings'; }
}