<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 22/01/2016
 * Time: 16:16
 */

namespace App\Classes;

class Breadcrumbs {

    private $breadcrumbs = [];

    public function push($name, $url) {
        $this->breadcrumbs[] = [
            'name'  => $name,
            'url'   => $url
        ];
    }

    public function getAll() {
        return $this->breadcrumbs;
    }
}