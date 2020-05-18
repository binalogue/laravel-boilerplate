<?php

if (!function_exists('accepted')) {
    /**
     * Check if the value under validation is true, 1, 'true', 'yes' or 'on'.
     *
     * @param  mixed  $array
     * @return void
     */
    function accepted($value)
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (bool) $value;
        }

        return in_array(strtolower($value), ['true', 'yes', 'on', 'si', 'sí']);
    }
}

if (!function_exists('flash')) {
    /**
     * Flash an array of key / value pairs to the session.
     *
     * @param  array  $array
     * @return void
     */
    function flash($array)
    {
        foreach ($array as $key => $value) {
            session()->flash($key, $value);
        }
    }
}

if (!function_exists('webp')) {
    /**
     * Switch image extensions to WebP when supported by the browser.
     *
     * @param  string  $imagePath
     * @return string
     */
    function webp($imagePath)
    {
        if (webp_support()) {
            $imagePath = preg_replace(
                '/(.+)*\.(?:jpe?g|png)/i',
                '$1.webp',
                $imagePath
            );
        }

        return asset($imagePath);
    }
}

if (!function_exists('webp_support')) {
    /**
     * Check if the browser has webP support.
     *
     * See: https://bmt-systems.com/blog/detecting-webp-support-and-deploying-webp-images-efficiently
     *
     * @return bool
     */
    function webp_support()
    {
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            if (strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') > 0) {
                return true;
            }
        }

        return false;
    }
}
