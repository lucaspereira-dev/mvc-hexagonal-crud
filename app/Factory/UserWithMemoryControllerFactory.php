<?php

namespace App\Factory;

use App\Controllers\UserController;
use App\Persistence\Models\UserMemory;
use Core\Services\UserService;

final readonly class UserWithMemoryControllerFactory {
    public static function create(): UserController
    {
        $userService = new UserService(new UserMemory());
        return new UserController($userService);
    }
}
