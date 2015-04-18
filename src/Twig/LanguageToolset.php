<?php
namespace Bolt\Extension\RixBeck\Languages\Twig;

use Bolt\Extension\RixBeck\Languages\Extension;

class LanguageToolset extends \Twig_Extension
{

    private $app;

    /**
     *
     * @var \Twig_Environment
     */
    private $twig = null;

    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->twig = $environment;
    }

    /**
     * Return the name of the extension
     */
    public function getName()
    {
        return 'languages.extension';
    }

    public function getFunctions()
    {
        return array(
            'getlang' => new \Twig_Function_Method($this, 'getLanguage')
        );
    }

    public function getLanguage()
    {
        return $this->app[Extension::CONTAINER]->getCurrentLanguage();
    }
}