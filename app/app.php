<?php

use Silex\Application;
use Xylophone\Provider\Controller\HomeControllerProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app = require __DIR__ . '/bootstrap.php';

// Routes
$app->mount('/', new HomeControllerProvider());

// Error handler
$app->error(function (Application $app, Exception $e, $code) {
    if (!$app['debug']) { // if in debug mode, use the normal error handler
        if ($e instanceof NotFoundHttpException) { // 404
            $template = '404.html.twig';
        } else { // 500
            $template = '500.html.twig';
        }

        return $app['twig']->render($template, [
            'code' => $e->getCode(),
        ]);
    }
});

return $app;