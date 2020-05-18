<?php

namespace Support\SeoTools;

use Support\SeoTools\Contracts\TwitterCards as TwitterCardsContract;

class TwitterCards implements TwitterCardsContract
{
    /**
     * @var string
     */
    protected $prefix = 'twitter:';

    /**
     * @var array
     */
    protected $html = [];

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var array
     */
    protected $images = [];

    /**
     * @param array $defaults
     */
    public function __construct(array $defaults = [])
    {
        $this->values = $defaults;
    }

    public function generate($minify = false)
    {
        $this->eachValue($this->values);
        $this->eachValue($this->images, 'images');

        return ($minify) ? implode('', $this->html) : implode(PHP_EOL, $this->html);
    }

    /**
     * Make tags.
     *
     * @param array       $values
     * @param null|string $prefix
     *
     * @internal param array $properties
     */
    protected function eachValue(array $values, $prefix = null)
    {
        foreach ($values as $key => $value) :
            if (is_array($value)) :
                $this->eachValue($value, $key);
            else :
                if ($key === 'image') :
                    $value = asset($value);
                elseif (is_numeric($key)) :
                    $key = $prefix . $key;
                elseif (is_string($prefix)) :
                    $key = $prefix . ':' . $key;
                endif;

                $this->html[] = $this->makeTag($key, $value);
            endif;
        endforeach;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return string
     *
     * @internal param string $values
     */
    private function makeTag($key, $value)
    {
        return '<meta name="' . $this->prefix . strip_tags($key) . '" content="' . strip_tags($value) . '" />';
    }

    public function addValue($key, $value)
    {
        $this->values[$key] = $value;

        return $this;
    }

    public function setTitle($title)
    {
        return $this->addValue('title', $title);
    }

    public function setType($type)
    {
        return $this->addValue('card', $type);
    }

    public function setSite($site)
    {
        return $this->addValue('site', $site);
    }

    public function setDescription($description)
    {
        return $this->addValue('description', htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false));
    }

    public function setUrl($url)
    {
        return $this->addValue('url', $url);
    }

    public function addImage($image)
    {
        foreach ((array) $image as $url) {
            $this->images[] = $url;
        }

        return $this;
    }

    public function setImages($images)
    {
        $this->images = [];

        return $this->addImage($images);
    }

    public function setImage($image)
    {
        return $this->addValue('image', $image);
    }
}