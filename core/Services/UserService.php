<?php

namespace Core\Services;

use Core\Adapters\UserInterfaceDao;
use Core\Adapters\UserServiceInterface;
use Core\Entities\User;
use Core\Exceptions\InvalidArgumentEmail;
use Core\Exceptions\UserException;
use Exception;
use InvalidArgumentException;

final class UserService implements UserServiceInterface
{

    public function __construct(
        private readonly UserInterfaceDao $userInterfaceDao
    ) {
    }

    public function create(array $payload): void
    {
        $user = new User(
            $payload["id"] ?? null,
            $payload["name"],
            $payload["email"],
            $payload["password"],
            $payload["birthday"]
        );
        $this->userInterfaceDao->saveUser($user);
    }

    public function update(array $user): void
    {
        if (!isset($user['id'])) {
            throw new InvalidArgumentException('Identificador não foi informado');
        }

        $this->findById($user['id']);

        try {
            $this->userInterfaceDao->updateUser($user);
        } catch (Exception $e) {
            throw new UserException($e->getMessage(), 500);
        }

    }

    public function delete(string $idUser): void
    {
        $this->findById($idUser);
        try {
            $this->userInterfaceDao->deleteUser($idUser);
        } catch (Exception $e) {
            throw new UserException($e->getMessage(), 500);
        }
    }

    public function findById(string $idUser): User
    {
        $userSearch = $this->userInterfaceDao->findUserById($idUser);
        if (is_null($userSearch) || empty($userSearch)) {
            throw new UserException('Nenhum usuário identificado com este ID', 404);
        }

        return new User(
            $userSearch["id"],
            $userSearch["name"],
            $userSearch["email"],
            $userSearch["password"],
            $userSearch["birthday"]
        );
    }

    public function findByEmail(string $email): User
    {
        $userSearch = $this->userInterfaceDao->findUserByEmail($email);
        if (is_null($userSearch) || empty($userSearch)) {
            throw new UserException('E-mail informado não cadastrado', 404);
        }

        return new User(
            $userSearch["id"],
            $userSearch["name"],
            $userSearch["email"],
            $userSearch["password"],
            $userSearch["birthday"]
        );
    }

    public function findAll(): array
    {
        $allUsers = $this->userInterfaceDao->getAllUsers();
        if (is_null($allUsers)) {
            return [];
        }

        return array_map(fn ($user) => new User(
            $user["id"],
            $user["name"],
            $user["email"],
            $user["password"],
            $user["birthday"]
        ), $allUsers);
    }
}
