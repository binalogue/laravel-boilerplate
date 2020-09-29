<?php

namespace Support\SeoTools;

use Illuminate\Config\Repository as Config;
use Illuminate\Support\Arr;
use Support\SeoTools\Contracts\MetaTags as MetaTagsContract;

class MetaTags implements MetaTagsContract
{
    /**
     * The meta title.
     *
     * @var string
     */
    protected $title;

    /**
     * The meta title session.
     *
     * @var string|null
     */
    protected $title_session;

    /**
     * The meta title session.
     *
     * @var string
     */
    protected $title_default;

    /**
     * The title tag separator.
     *
     * @var string
     */
    protected $title_separator;

    /**
     * The meta description.
     *
     * @var string|bool|null
     */
    protected $description;

    /**
     * The meta keywords.
     *
     * @var array|\Illuminate\Support\Collection
     */
    protected $keywords = [];

    /**
     * extra metatags.
     *
     * @var array
     */
    protected $metatags = [];

    /**
     * The canonical URL.
     *
     * @var string|null
     */
    protected $canonical;

    /**
     * The AMP URL.
     *
     * @var string|null
     */
    protected $amphtml;

    /**
     * The prev URL in pagination.
     *
     * @var string|null
     */
    protected $prev;

    /**
     * The next URL in pagination.
     *
     * @var string|null
     */
    protected $next;

    /**
     * The alternate languages.
     *
     * @var array
     */
    protected $alternateLanguages = [];

    /**
     * The meta robots.
     *
     * @var string|null
     */
    protected $robots;

    /**
     * @var Config
     */
    protected $config;

    /**
     * The webmaster tags.
     *
     * @var array
     */
    protected $webmasterTags = [
        'google' => 'google-site-verification',
        'bing' => 'msvalidate.01',
        'alexa' => 'alexaVerifyID',
        'pintrest' => 'p:domain_verify',
        'yandex' => 'yandex-verification',
    ];

    /**
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function generate($minify = false)
    {
        $this->loadWebMasterTags();

        $title = $this->getTitle();
        $description = $this->getDescription();
        $keywords = $this->getKeywords();
        $metatags = $this->getMetatags();
        $canonical = $this->getCanonical();
        $amphtml = $this->getAmpHtml();
        $prev = $this->getPrev();
        $next = $this->getNext();
        $languages = $this->getAlternateLanguages();
        $robots = $this->getRobots();

        $html = [];

        if ($title) {
            $html[] = Arr::get($this->config, 'add_notranslate_class', false)
                ? "<title class=\"notranslate\">$title</title>"
                : "<title>$title</title>";
        }

        if ($description) {
            $html[] = "<meta name=\"description\" content=\"{$description}\">";
        }

        if (! empty($keywords)) {
            if ($keywords instanceof \Illuminate\Support\Collection) {
                $keywords = $keywords->toArray();
            }

            $keywords = implode(', ', $keywords);
            $html[] = "<meta name=\"keywords\" content=\"{$keywords}\">";
        }

        foreach ($metatags as $key => $value) {
            $name = $value[0];
            $content = $value[1];

            // if $content is empty jump to nest
            if (empty($content)) {
                continue;
            }

            $html[] = "<meta {$name}=\"{$key}\" content=\"{$content}\">";
        }

        if ($canonical) {
            $html[] = "<link rel=\"canonical\" href=\"{$canonical}\">";
        }

        if ($amphtml) {
            $html[] = "<link rel=\"amphtml\" href=\"{$amphtml}\">";
        }

        if ($prev) {
            $html[] = "<link rel=\"prev\" href=\"{$prev}\">";
        }

        if ($next) {
            $html[] = "<link rel=\"next\" href=\"{$next}\">";
        }

        foreach ($languages as $lang) {
            $html[] = "<link rel=\"alternate\" hreflang=\"{$lang['lang']}\" href=\"{$lang['url']}\">";
        }

        if ($robots) {
            $html[] = "<meta name=\"robots\" content=\"{$robots}\">";
        }

        return ($minify) ? implode('', $html) : implode(PHP_EOL, $html);
    }

    public function generateVueMeta()
    {
        $title = $this->getTitle();

        $meta = [];

        if ($title) {
            $meta['title'] = $title;
        }

        return $meta;
    }

    public function setTitle($title, $appendDefault = true)
    {
        // clean title
        $title = strip_tags($title);

        // store title session
        $this->title_session = $title;

        // store title
        if (true === $appendDefault) {
            $this->title = $this->parseTitle($title);
        } else {
            $this->title = $title;
        }

        return $this;
    }

    public function setTitleDefault($default)
    {
        $this->title_default = $default;

        return $this;
    }

    public function setTitleSeparator($separator)
    {
        $this->title_separator = $separator;

        return $this;
    }

    public function setDescription($description)
    {
        $this->description = ($description === false)
            ? $description
            : htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false);

        return $this;
    }

    public function setKeywords($keywords)
    {
        if (! is_array($keywords)) {
            $keywords = explode(', ', $keywords);
        }

        // clean keywords
        $keywords = array_map('strip_tags', $keywords);

        // store keywords
        $this->keywords = $keywords;

        return $this;
    }

    public function addKeyword($keyword)
    {
        if (is_array($keyword)) {
            $this->keywords = array_merge($keyword, $this->keywords);
        } else {
            $this->keywords[] = strip_tags($keyword);
        }

        return $this;
    }

    public function removeMeta($key)
    {
        Arr::forget($this->metatags, $key);

        return $this;
    }

    public function addMeta($meta, $value = null, $name = 'name')
    {
        // multiple metas
        if (is_array($meta)) {
            foreach ($meta as $key => $value) {
                $this->metatags[$key] = [$name, $value];
            }
        } else {
            $this->metatags[$meta] = [$name, $value];
        }

        return $this;
    }

    public function setCanonical($url)
    {
        $this->canonical = $url;

        return $this;
    }

    /**
     * Sets the AMP html URL.
     *
     * @param string $url
     *
     * @return MetaTagsContract
     */
    public function setAmpHtml($url)
    {
        $this->amphtml = $url;

        return $this;
    }

    public function setPrev($url)
    {
        $this->prev = $url;

        return $this;
    }

    public function setNext($url)
    {
        $this->next = $url;

        return $this;
    }

    public function addAlternateLanguage($lang, $url)
    {
        $this->alternateLanguages[] = ['lang' => $lang, 'url' => $url];

        return $this;
    }

    public function addAlternateLanguages(array $languages)
    {
        $this->alternateLanguages = array_merge($this->alternateLanguages, $languages);

        return $this;
    }

    /**
     * Sets the meta robots.
     *
     * @param string $robots
     *
     * @return MetaTagsContract
     */
    public function setRobots($robots)
    {
        $this->robots = $robots;

        return $this;
    }

    public function getTitle()
    {
        return $this->title ?: $this->getDefaultTitle();
    }

    public function getDefaultTitle()
    {
        if (empty($this->title_default)) {
            return $this->config->get('defaults.title', null);
        }

        return $this->title_default;
    }

    public function getTitleSession()
    {
        return $this->title_session ?: $this->getTitle();
    }

    public function getTitleSeparator()
    {
        return $this->title_separator ?: $this->config->get('defaults.separator', ' - ');
    }

    public function getKeywords()
    {
        return $this->keywords ?: $this->config->get('defaults.keywords', []);
    }

    public function getMetatags()
    {
        return $this->metatags;
    }

    public function getDescription()
    {
        if ($this->description === false) {
            return null;
        }

        return $this->description ?: $this->config->get('defaults.description', null);
    }

    public function getCanonical()
    {
        $canonical_config = $this->config->get('defaults.canonical', false);

        return $this->canonical ?: (($canonical_config === null) ? app('url')->full() : $canonical_config);
    }

    /**
     * Get the AMP html URL.
     *
     * @return string
     */
    public function getAmpHtml()
    {
        return $this->amphtml;
    }

    public function getPrev()
    {
        return $this->prev;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function getAlternateLanguages()
    {
        return $this->alternateLanguages;
    }

    /**
     * Get meta robots.
     *
     * @return string
     */
    public function getRobots()
    {
        return $this->robots ?: $this->config->get('defaults.robots', null);
    }

    public function reset()
    {
        $this->description = null;
        $this->title_session = null;
        $this->next = null;
        $this->prev = null;
        $this->canonical = null;
        $this->amphtml = null;
        $this->metatags = [];
        $this->keywords = [];
        $this->alternateLanguages = [];
        $this->robots = null;
    }

    /**
     * Get parsed title.
     *
     * @param string $title
     *
     * @return string
     */
    protected function parseTitle($title)
    {
        $default = $this->getDefaultTitle();

        if (empty($default)) {
            return $title;
        }
        $defaultBefore = $this->config->get('defaults.title_before', false);

        return $defaultBefore
            ? $default.$this->getTitleSeparator().$title
            : $title.$this->getTitleSeparator().$default;
    }

    /**
     * Load webmaster tags from configuration.
     */
    protected function loadWebMasterTags(): void
    {
        foreach ($this->config->get('webmaster_tags', []) as $name => $value) {
            if (! empty($value)) {
                $meta = Arr::get($this->webmasterTags, $name, $name);
                $this->addMeta($meta, $value);
            }
        }
    }
}
