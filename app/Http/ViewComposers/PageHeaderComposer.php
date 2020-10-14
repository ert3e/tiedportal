<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 22/01/2016
 * Time: 16:05
 */

namespace App\Http\ViewComposers;

use \Breadcrumbs;
use Illuminate\Contracts\View\View;

class PageHeaderComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $breadcrumbs = Breadcrumbs::getAll();
        $last = array_pop($breadcrumbs);
        $view->with('breadcrumbs', $breadcrumbs)->with('title', $last['name']);
    }
}