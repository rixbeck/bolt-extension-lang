<?php

namespace Bolt\Extension\VendorName\BoltExtensionName;

class Extension extends \Bolt\BaseExtension
{

    public function getName()
    {
        return array_pop(explode('\\',__NAMESPACE__));
    }

    /**
     *
     */
    public function initialize()
    {
        /*
         * Config
         */
        $this->setConfig();

        /*
         * Backend
         */
        if ($this->app['config']->getWhichEnd() == 'backend') {
        }

        /*
         * Frontend
         */
        if ($this->app['config']->getWhichEnd() == 'frontend') {
        }

    }
}
