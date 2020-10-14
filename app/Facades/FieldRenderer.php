<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 16/02/2016
 * Time: 15:30
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class FieldRenderer extends Facade
{
    protected static function getFacadeAccessor() { return 'fieldrenderer'; }
}