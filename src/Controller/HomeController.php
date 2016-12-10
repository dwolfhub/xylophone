<?php
namespace Xylophone\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomeController
 * @package Xylophone\Controller
 */
class HomeController
{

    /**
     * @param Application $app
     * @param Request $request
     * @return string
     */
    public function index(Application $app, Request $request)
    {
        return $app['twig']->render('layout.html.twig');
    }
}