<?php

namespace Core\Interfaces;

use Core\Entities\User;

interface UserServiceInterface {
    public function __construct(UserInterfaceDao $userInterfaceDao);
    
    public function create(array $payload): void;

    public function update(array $user): void;

    public function delete(string $idUser): void;

    public function findById(string $idUser): User;

    public function findByEmail(string $email): User;

    /**
     * @return array<User>
     */
    public function findAll(): array;
}
