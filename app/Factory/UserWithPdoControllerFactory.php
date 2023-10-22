<?php

namespace App\Factory;

use App\Controllers\UserController;
use App\Persistence\Connections\MysqlPdo;
use App\Persistence\Models\UserSqlPdo;
use Core\Services\UserService;

final readonly class UserWithPdoControllerFactory {
    public static function create(): UserController
    {
        $connection = new MysqlPdo();
        $userRepository = new UserSqlPdo($connection);
        $userService = new UserService($userRepository);
        return new UserController($userService);
    }
}