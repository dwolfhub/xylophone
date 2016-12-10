<?php

namespace Xylophone\Provider;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Doctrine\DBAL\Migrations\Tools\Console\Command;
use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;

/**
 * Class MigrationServiceProvider
 * @package Xylophone\Provider
 */
class MigrationServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $config = new Configuration($app['db']);
        $migrationDir = dirname(__DIR__) . '/Resource/Migration/';

        $config->setMigrationsNamespace('Xylophone\Resource\Migration');
        $config->setMigrationsDirectory($migrationDir);
        $config->registerMigrationsFromDirectory($migrationDir);
        $config->setName('migrations');
        $config->setMigrationsTableName('migrations');

        $commands = [
            new Command\DiffCommand(),
            new Command\ExecuteCommand(),
            new Command\GenerateCommand(),
            new Command\MigrateCommand(),
            new Command\StatusCommand(),
            new Command\VersionCommand(),
        ];

        /** @var AbstractCommand $command */
        foreach ($commands as $command) {
            $command->setMigrationConfiguration($config);
            $app['console']->add($command);
        }
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
}