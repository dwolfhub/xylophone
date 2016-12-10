# Xylophone 
A Silex skeleton project.

## Up and Running

```
vagrant up
vagrant ssh
cd /var/www
nvm install v6.9.1
npm run watch
```

The site will be available at `http://localhost:8081` from your host machine.

## Configuration

Config files are located in `config/`. 
The configuration provider uses the environment to determine which config file to load.
The environment is determined using the `APPLICATION_ENV` environment variable, but defaults to `vagrant`.
For local development, juse copy the `config/local-sample.yml` file to `config/local.yml` and update values therein.

## Frontend

### npm
[npm](https://www.npmjs.com/) is the package manager used for installing build tools as well as third-party dependencies. Configuration is located in `package.json`.

Run `npm install` to download required tools and modules.

### JavaScript

JavaScript files are located in `app/assets/js/`. 
The main entry point for the app is `app/assets/js/main.js`. 
Scripts are compiled using webpack with the babel plugin. 
An example module for your reference is located at `app/assets/js/modules/module.js`.

### SASS

[SASS](http://sass-lang.com/) is used for extending CSS with new features and compiles into CSS. 
The SASS files are located at `app/assets/scss`, and the main SASS file is `app/assets/scss/main.scss`.

## Console Commands

Xylophone uses the [Symfony Console Component](http://symfony.com/doc/current/components/console/introduction.html) to perform tasks.
Run `app/zylophone` to see a list of available commands.
To create your own commands, extend the `Knp\Command\Command` class.
An example command is located at `src/Command/NamespaceCommand.php`.


## Database

### Migrations

Migrations are stored in the `src/Resource/Migration` folder. Run `./app/xylophone` in the app root folder to view migration commands:

```Text
migrations
  migrations:diff      Generate a migration by comparing your current database to your mapping information.
  migrations:execute   Execute a single migration version up or down manually.
  migrations:generate  Generate a blank migration class.
  migrations:migrate   Execute a migration to a specified version or the latest available version.
  migrations:status    View the status of a set of migrations.
  migrations:version   Manually add and delete migration versions from the version table.
```

### Query Repositories

The abstract query repository can be found in `src/QueryRepository/`. Extend it to create your own repositories. Then use them like so:

```php
$myRepo = new Xylophone\QueryRepository\MyQueryRepo($app['db']);
$results = $myRepo->myMethod();
```

## Routes and Controllers

Add your route definitions to `app/app.php`.
There is a home route there for your reference:

```php
$app->get('/', 'Xylophone\Controller\HomeController::index')
    ->bind('home');
```

This route will direct the uri `/` to the index method of the 'Xylophone\Controller\HomeController' class. The bind command will allow you to reference this route in your templates like this: `{{ path('home') }}`.

Check out the [official docs](http://silex.sensiolabs.org/doc/usage.html#routing) for more info.

### Caching

If you want to cache a response, simply add the `Cache-Control` header to something like `s-maxage=3600, public`. The standard setup will use the cache folder to store response and serve responses from there without having to bootstrap the app.

## Views

### Twig

[Twig](http://twig.sensiolabs.org/) templates should be placed in `frontend/twig`. Render a template using `$app['twig']->render('filename.html.twig', ['mykey' => 'myvalue']);`.

```Text
Global Variables
debug         Boolean containing the application debug state
js_filename   dynamically revisioned name of the compiled JavaScript modules
css_filename  dynamically revisioned name of the compiled SASS files

```

## Unit Tests

Put your phpunit tests in the `tests/` folder. Extend the `\Xylophone\Test\AbstractTestCase` class in order to have access to things like the web crawler. Here's an example:

```php
use \Xylophone\Test\AbstractTestCase;

class SomeTest extends AbstractTestCase
{
    public function testSomething()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
    
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("Hello World")'));
    }
}
```

Check out the [official documentation](http://silex.sensiolabs.org/doc/testing.html) for more info.

## Logging

The logging service is available by using $app['monolog']. The log files reside in `app/logs/`. Here are some examples:

```php
$app['monolog']->info('script started');
$app['monolog']->error('Failed to call function', ['key', $value]);
```

