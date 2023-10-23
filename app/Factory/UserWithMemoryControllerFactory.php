<?php

namespace App\Factory;

use App\Controllers\UserController;
use App\Persistence\Models\UserMemory;
use Core\Services\UserServiceImpl;

final readonly class UserWithMemoryControllerFactory {
    public static function create(): UserController
    {
        $userService = new UserServiceImpl(new UserMemory());
        return new UserController($userService);
    }
}
