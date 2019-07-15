<?php

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
