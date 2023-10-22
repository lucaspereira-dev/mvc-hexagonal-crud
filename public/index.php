<?php

use App\Factory\UserWithPdoControllerFactory;
use DI\Container;
use Slim\Factory\AppFactory;
use function Routes\routesUsers;
use function Routes\routesHomePage;
use App\Controllers\UserController;
use Symfony\Component\Dotenv\Dotenv;
use Slim\Middleware\StaticMiddleware;

$pathEnv = dirname(__DIR__) . '/.env';
require_once __DIR__ . '/../vendor/autoload.php';

$env = new Dotenv();
$env->bootEnv($pathEnv);

$container = new Container();
$container->set(UserController::class, function () {
    return UserWithPdoControllerFactory::create();
});

AppFactory::setContainer($container);
$app = AppFactory::create();
routesHomePage($app);
routesUsers($app);
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->run();
