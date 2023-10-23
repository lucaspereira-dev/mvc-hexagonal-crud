<?php

namespace App\Factory;

use App\Controllers\UserController;
use App\Persistence\Models\UserDaoAdapterMemory;
use Core\Services\UserServiceImpl;

final readonly class UserWithMemoryControllerFactory {
    public static function create(): UserController
    {
        $userService = new UserServiceImpl(new UserDaoAdapterMemory());
        return new UserController($userService);
    }
}
