<?php

namespace Routes;

use Slim\App;
use App\Controllers\UserController;
use Slim\Routing\RouteCollectorProxy;

function routesUsers(App $app) {
  $app->group('/users', function(RouteCollectorProxy $usersPrefix) {
    $usersPrefix->post('', [UserController::class, 'createUser']);
    $usersPrefix->put('/{id}', [UserController::class, 'updateUser']);
    $usersPrefix->delete('/{id}', [UserController::class, 'deleteUser']);
    $usersPrefix->get('/{id}', [UserController::class, 'getUserById']);
    $usersPrefix->get('', [UserController::class, 'getAllUsers']);
  });
}
