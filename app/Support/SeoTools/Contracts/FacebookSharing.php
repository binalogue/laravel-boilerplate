<?php

namespace Support\SeoTools\Contracts;

interface FacebookSharing
{
    /**
     * @param array $config
     */
    public function __construct(array $config = []);

    /**
     * @param bool $minify
     *
     * @return string
     */
    public function generate($minify = false);

    /**
     * Get the app ID.
     *
     * @return string
     */
    public function getAppId();
}
