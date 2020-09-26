<?php

namespace Support\SeoTools;

use Support\SeoTools\Contracts\FacebookSharing as FacebookSharingContract;

class FacebookSharing implements FacebookSharingContract
{
    /**
     * @var string
     */
    protected $prefix = 'fb:';

    /**
     * @var string
     */
    protected $appId = '';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->appId = $config['app_id'];
    }

    public function generate($minify = false)
    {
        $html = [];

        $appId = $this->getAppId();

        if ($appId) {
            $html[] = "<meta property=\"{$this->prefix}app_id\" content=\"{$appId}\">";
        }

        return ($minify) ? implode('', $html) : implode(PHP_EOL, $html);
    }

    public function getAppId()
    {
        return $this->appId;
    }
}
