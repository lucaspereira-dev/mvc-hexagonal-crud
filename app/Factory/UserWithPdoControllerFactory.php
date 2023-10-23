<?php

namespace App\Factory;

use App\Controllers\UserController;
use App\Persistence\Connections\MysqlPdo;
use App\Persistence\Models\UserDaoAdapterSql;
use Core\Services\UserServiceImpl;

final readonly class UserWithPdoControllerFactory
{
    public static function create(): UserController
    {
        $connection = new MysqlPdo(
            getenv('DB_HOST'),
            getenv('DB_DATABASE'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );
        $userRepository = new UserDaoAdapterSql($connection);
        $userService = new UserServiceImpl($userRepository);
        return new UserController($userService);
    }
}
