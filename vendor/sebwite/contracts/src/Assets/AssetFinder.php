<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Sebwite\Contracts\Assets;

/**
 * This is the class AssetFinderInterface.
 *
 * @package        Sebwite\Assets
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
interface AssetFinder
{
    public function getPath($key);
}
