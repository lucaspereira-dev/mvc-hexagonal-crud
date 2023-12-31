<?php

namespace Core\Interfaces;

use Core\Entities\User;

interface UserDao {
    public function saveUser(User $user): void;
    public function updateUser(array $user): void;
    public function findUserById(string $idUser): array | null;
    public function findUserByEmail(string $email): array | null;
    public function getAllUsers(): array | null;
    public function deleteUser(string $idUser): void;
}
