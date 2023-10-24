<?php

namespace Routes;

use Slim\App;
use App\Controllers\UserController;
use Slim\Routing\RouteCollectorProxy;

function userRoutes(App $app) {
  $app->group('/users', function(RouteCollectorProxy $route) {
    $route->post('', [UserController::class, 'createUser']);
    $route->put('/{id}', [UserController::class, 'updateUser']);
    $route->delete('/{id}', [UserController::class, 'deleteUser']);
    $route->get('/{id}', [UserController::class, 'getUserById']);
    $route->get('', [UserController::class, 'getAllUsers']);
  });
}
