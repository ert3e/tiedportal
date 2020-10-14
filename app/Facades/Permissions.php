<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 01/02/2016
 * Time: 15:19
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class Permissions extends Facade
{
    protected static function getFacadeAccessor() { return 'permissions'; }
}