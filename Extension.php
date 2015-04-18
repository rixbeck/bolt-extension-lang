<?php
namespace Bolt\Extension\RixBeck\Languages;

use Bolt\Extension\RixBeck\Languages\Controller\LanguageController;

class Extension extends \Bolt\BaseExtension
{

    const NAME = 'languages';

    const CONTAINER = 'extensions.languages';

    protected $language;

    public function getName()
    {
        return static::NAME;
    }

    /**
     */
    public function initialize()
    {
        /*
         * Frontend
         */
        if ($this->app['config']->getWhichEnd() == 'frontend') {
            $twigmodule = new Twig\LanguageToolset($this->app);
            $this->app['twig']->addExtension($twigmodule);
        }
    }

    public function setLanguageByContenttype($contenttypeslug)
    {
        // Get the language of current cttype
        $contenttype = $this->app['storage']->getContenttype($contenttypeslug);
        // if current land differs than req slug, align current lang
        if ($contenttype['language']) {
            $lang = $contenttype['language']['id'];
            if ($this->getCurrentLanguage() != $lang) {
                $this->setCurrentLanguage($lang);
            }
        }

        return $this;
    }

    public function getContenttypeSlug($contenttypeslug)
    {
        $contenttype = $this->app['storage']->getContenttype($contenttypeslug);
        if ($contenttype['language']) {
            $lang = $this->getCurrentLanguage();
            if ($lang !== $contenttype['language']['id']) {
                $contenttypeslug = $contenttype['language'][$lang];
            }
        }

        return $contenttypeslug;
    }

    public function getHomepage()
    {
        return $this->getConfig('homepage')[$this->getCurrentLanguage()];
    }

    public function createEntryUri()
    {
        return $this->app['config']->get('general/branding/path') . '/extensions/' . strtolower($this->getName());
    }

    public function getConfig($path = '', $delim = '/')
    {
        $conf = parent::getConfig();
        if ($path) {
            $segments = explode($delim, $path);
            foreach ($segments as $index) {
                if (array_key_exists($index, $conf)) {
                    $conf = $conf[$index];
                } else {
                    return false;
                }
            }
        }

        return $conf;
    }

    public function getCurrentLanguage()
    {
        if ($this->language) {
            return $this->language;
        }
        $this->language = $this->app['session']->get(self::CONTAINER . '.lang');
        if (! $this->language) {
            $this->setCurrentLanguage($this->getDefaultLanguage());
        }

        return $this->language;
    }

    public function getDefaultLanguage()
    {
        return 'en';
    }

    public function setCurrentLanguage($lang)
    {
        $this->app['session']->set(self::CONTAINER . '.lang', $this->language = $lang);

        return $this;
    }
}
