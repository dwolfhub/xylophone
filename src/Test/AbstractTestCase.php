<?php

namespace Xylophone\Test;

use Silex\WebTestCase;

abstract class AbstractTestCase extends WebTestCase
{
    public function createApplication()
    {
        $app = require dirname(dirname(__DIR__)) . '/app/app.php';

        // protect against accidentally running unit tests in production
        if (!$app['debug']) {
            trigger_error('Attempting to run unit tests with debug disabled.', E_USER_WARNING);
        }

        // remove exception handler so we get clean error messages in CLI
        unset($app['exception_handler']);

        return $app;
    }
}