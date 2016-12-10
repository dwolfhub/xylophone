<?php
namespace Xylophone\Provider\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

/**
 * Class HomeControllerProvider
 *
 * @package Xylophone\Provider\Controller
 */
class HomeControllerProvider implements ControllerProviderInterface
{
    /**
     * @param Application $app
     *
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'Xylophone\Controller\HomeController::index')
            ->bind('home');

        return $controllers;
    }
}