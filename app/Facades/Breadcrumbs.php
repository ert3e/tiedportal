<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 22/01/2016
 * Time: 16:18
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class Breadcrumbs extends Facade
{
    protected static function getFacadeAccessor() { return 'breadcrumbs'; }
}