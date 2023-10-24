<?php

use DI\Container;
use Slim\Factory\AppFactory;
use App\Controllers\UserController;
use Symfony\Component\Dotenv\Dotenv;
use App\Factory\UserWithPdoControllerFactory;

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

// Carregamento de rotas (Autoload files composer)
Routes\homeRoutes($app);
Routes\staticRoutes($app);
Routes\userRoutes($app);

$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->run();
