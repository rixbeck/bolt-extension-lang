<?php
namespace Bolt\Extension\RixBeck\Languages\Controller;

use Silex\Application;
use Bolt\Controllers\Frontend;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Bolt\Extension\RixBeck\Languages\Extension;

class LanguageController extends Frontend
{

    public function record(Application $app, $contenttypeslug, $slug)
    {
        $app[Extension::CONTAINER]->setLanguageByContenttype($contenttypeslug);

        return parent::record($app, $contenttypeslug, $slug);
    }

    public function listing(Application $app, $contenttypeslug)
    {
        $app[Extension::CONTAINER]->setLanguageByContenttype($contenttypeslug);

        return parent::listing($app, $contenttypeslug);
    }

    public function homepage(Application $app)
    {
        $home = $app[Extension::CONTAINER]->getHomepage();
        $content = $app['storage']->getContent($home);

        $template = $app['templatechooser']->homepage();

        if (is_array($content)) {
            $first = current($content);
            $app['twig']->addGlobal('records', $content);
            $app['twig']->addGlobal($first->contenttype['slug'], $content);
        } elseif (! empty($content)) {
            $app['twig']->addGlobal('record', $content);
            $app['twig']->addGlobal($content->contenttype['singular_slug'], $content);
        }

        return $this->render($app, $template, 'homepage');
    }

    protected function render(Application $app, $template, $title)
    {
        try {
            return $app['twig']->render($template);
        } catch (\Twig_Error_Loader $e) {
            $error = sprintf('Rendering %s failed: %s', $title, $e->getMessage());

            // Log it
            $app['logger.system']->error($error, array(
                'event' => 'twig'
            ));

            // Set the template error
            if (isset($app['twig.logger'])) {
                $app['twig.logger']->setTrackedValue('templateerror', $error);
            }

            // Abort ship
            $app->abort(Response::HTTP_INTERNAL_SERVER_ERROR, $error);
        }
    }
}