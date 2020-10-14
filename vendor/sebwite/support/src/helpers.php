<?php
/**
 * Sebwite Support helper methods
 *
 * @author    Sebwite Dev Team
 * @copyright Copyright (c) 2015, Sebwite
 * @license   https://tldrlegal.com/license/mit-license MIT License
 * @package   Sebwite\Support
 */

if (!function_exists('stringy')) {
/**
     * stringy method
     *
     * @param      $str
     * @param null $encoding
     *
     * @return \Stringy\Stringy
     */
    function stringy($str, $encoding = null)
    {

        return \Stringy\Stringy::create($str);
    }
}

if (!function_exists('path_join')) {
    function path_join()
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'join' ], func_get_args());
    }
}

if (!function_exists('path_real')) {
    function path_real()
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'real' ], func_get_args());
    }
}

if (!function_exists('path_njoin')) {
    function path_njoin()
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'njoin' ], func_get_args());
    }
}

if (!function_exists('path_is_absolute')) {
    function path_is_absolute($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'isAbsolute' ], func_get_args());
    }
}

if (!function_exists('path_is_relative')) {
    function path_is_relative($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'isRelative' ], func_get_args());
    }
}

if (!function_exists('path_get_directory')) {
    function path_get_directory($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'getDirectory' ], func_get_args());
    }
}

if (!function_exists('path_get_extension')) {
    function path_get_extension($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'getExtension' ], func_get_args());
    }
}

if (!function_exists('path_get_filename')) {
    function path_get_filename($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'getFilename' ], func_get_args());
    }
}

if (!function_exists('path_relative')) {
    function path_relative($from, $basePath)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'makeRelative' ], func_get_args());
    }
}

if (!function_exists('path_absolute')) {
    function path_absolute($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'makeAbsolute' ], func_get_args());
    }
}

if (!function_exists('path_normalize')) {
    function path_normalize($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'canonicalize' ], func_get_args());
    }
}

if (!function_exists('path_canonicalize')) {
    function path_canonicalize($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'canonicalize' ], func_get_args());
    }
}


if (!function_exists('path_canonicalize')) {
    function path_get_home()
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'getHome' ], func_get_args());
    }
}


if (!function_exists('path_canonicalize')) {
    function path_canonicalize($path)
    {
        return forward_static_call_array([ 'Sebwite\Support\Path', 'canonicalize' ], func_get_args());
    }
}
