<?php namespace App\AppTraits;
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 25/04/2016
 * Time: 11:10
 */


trait Names {
    public static function getNamespace() {
        return implode('\\', array_slice(explode('\\', get_called_class()), 0, -1));
    }

    public static function getBaseClassName() {
        return basename(str_replace('\\', '/', get_called_class()));
    }
}
