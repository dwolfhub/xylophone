<?php

use Knp\Provider\ConsoleServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Xylophone\Twig\Extension\VersionedAssetExtension;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();

// Environment
$app['env'] = getenv('APPLICATION_ENV') ?: 'vagrant';

// Config
$app['config'] = Yaml::parse(file_get_contents(__DIR__ . '/../config/default.yml'));
if (file_exists(__DIR__ . '/../config/local.yml')) {
    $app['config'] = array_replace_recursive(
        $app['config'],
        Yaml::parse(file_get_contents(__DIR__ . '/../config/local.yml'))
    );
}

// Debug mode?
$app['debug'] = $app['config']['debug'];
if ($app['debug']) {
    @ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}

// Console Commands
$app->register(
    new ConsoleServiceProvider(),
    [
        'console.name' => $app['config']['name'],
        'console.version' => $app['config']['version'],
        'console.project_directory' => __DIR__ . '/../',
    ]
);

// Database
$app->register(
    new DoctrineServiceProvider(),
    [
        'db.options' => $app['config']['database'],
    ]
);

// Logging
$app->register(
    new MonologServiceProvider(),
    [
        'monolog.logfile' => __DIR__ . '/logs/app.log',
        'monolog.level' => constant('\Monolog\Logger::' . $app['config']['log']['level']),
        'monolog.name' => $app['config']['name'],
    ]
);

// Cache
$app->register(
    new Silex\Provider\HttpCacheServiceProvider(),
    [
        'http_cache.cache_dir' => __DIR__ . '/cache/',
    ]
);

// Templates
$app->register(
    new TwigServiceProvider(),
    [
        'twig.path' => __DIR__ . '/../app/templates',
        'twig.options' => [
            'cache' => __DIR__ . '/cache/',
        ],
    ]
);

// Generating URLs
// web profiler
if ($app['debug']) {
    $app->register(
        new WebProfilerServiceProvider(),
        [
            'profiler.cache_dir' => __DIR__ . '/cache/profiler',
        ]
    );
    $app->register(new HttpFragmentServiceProvider());
    $app->register(new ServiceControllerServiceProvider());
}

// Adds versioned_asset function, e.g. versioned_asset('main.css')
$app->extend('twig', function (Twig_Environment $twig, Application $app) {
    $twig->addExtension(
        new VersionedAssetExtension(
            __DIR__ . '/../public_html/dist/assets.json'
        )
    );

    return $twig;
});

/**
 * In order to get auto-complete in IDEs like PHPStorm,
 * uncomment this line and process a request.
 * This will dump a pimple.json file into the root folder.
 *
 * More Info:
 * Pimple Dumper: https://github.com/Sorien/silex-pimple-dumper
 * PHPStorm Plugin: https://github.com/Sorien/silex-idea-plugin
 */
//$app->register(new Sorien\Provider\PimpleDumpProvider());

return $app;