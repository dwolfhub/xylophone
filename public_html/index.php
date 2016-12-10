<?php

$app = require_once __DIR__ . '/../app/app.php';

/**
 * If using the http cache provider, use this line instead of the below
 */
// $app['http_cache']->run();

$app->run();
