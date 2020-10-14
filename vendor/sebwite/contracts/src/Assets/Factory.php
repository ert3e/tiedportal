<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Sebwite\Contracts\Assets;

use Sebwite\Assets\Assetic\Asset;
use Sebwite\Assets\Assetic\AssetInterface;
use Sebwite\Assets\Builder\Area;
use Sebwite\Assets\Compiler\Compiler;

/**
 * This is the class AssetFactory.
 *
 * @package        Sebwite\Assets
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
interface Factory
{
    /**
     * Creates an AssetInterface asset
     *
     * @param       $handle
     * @param       $path
     * @param array $dependencies
     *
     * @return Asset
     */
    public function create($handle, $path, array $dependencies = [ ]);

    /**
     * createCollection method
     *
     * @param array $assets
     *
     * @return AssetInterface
     */
    public function createCollection(array $assets = [ ]);

    /**
     * query method
     *
     * @param string $query - The query, wich is actually a NamespacedItemResolver key.
     *
     * @return \Sebwite\Assets\Assetic\Asset[]|\Sebwite\Assets\Builder\Area|\Sebwite\Assets\Builder\Group
     */
    public function query($query);

    /**
     * Compiles the result of the given query
     *
     * @param     string $type
     * @param     string $query - The query, wich is actually a NamespacedItemResolver key.
     * @param bool       $combine
     *
     * @return \Sebwite\Assets\Compiler\CompiledCollection
     */
    public function compile($type, $query, $combine = true);

    /**
     * Get the Area that references $id
     *
     * @param $id
     *
     * @return Area
     */
    public function area($id);

    /**
     * Returns a <script src=""> html string
     *
     * @param       $key
     * @param array $attributes
     * @param bool  $secure
     *
     * @return string
     */
    public function script($key, array $attributes = [ ], $secure = false);

    /**
     * Returns a <link href=""> html string
     *
     * @param       $key
     * @param array $attributes
     * @param bool  $secure
     *
     * @return string
     */
    public function style($key, array $attributes = [ ], $secure = false);

    /**
     * @return Compiler
     */
    public function getCompiler();

    /**
     * addGlobalFilter
     *
     * @param $extension
     * @param $callback
     *
     * @return \Sebwite\Assets\Factory
     */
    public function addGlobalFilter($extension, $callback);

    /**
     * getGlobalFilters
     *
     * @param $extension
     *
     * @return array
     */
    public function getGlobalFilters($extension);

    /**
     * Removes all chached files
     */
    public function deleteAllCached();

    /**
     * Resolves the type of the given asset
     *
     * @param \Sebwite\Assets\Assetic\AssetInterface $asset
     *
     * @return int|string
     */
    public function resolveType(AssetInterface $asset);

    /**
     * Returns the absolute path to the asset. Uses the AssetFinder to retreive the path with the given key
     *
     * @param $key
     *
     * @return mixed
     */
    public function getPath($key);

    /**
     * Returns the url to the asset. Uses the AssetFinder to retreive the path with the given key
     *
     * @param $key
     *
     * @return string
     */
    public function getUrl($key);

    /**
     * Returns the uri to the asset. Uses the AssetFinder to retreive the path with the given key
     *
     * @param $key
     *
     * @return string
     */
    public function getUri($key);

    /**
     * Returns the cache directory path, relative to the public_path
     *
     * @return mixed
     */
    public function getCachePath();

    /**
     * Set the cachePath value
     *
     * @param string $cachePath
     *
     * @return \Sebwite\Assets\Factory
     */
    public function setCachePath($cachePath);

    /**
     * @param null $debug
     */
    public function setDebug($debug);

    /**
     * isDebug method
     *
     * @return bool|null
     */
    public function isDebug();

    /**
     * @return mixed
     */
    public function getTypes();

    /**
     * Set the types value
     *
     * @param mixed $types
     *
     * @return \Sebwite\Assets\Factory
     */
    public function setTypes($types);
}
