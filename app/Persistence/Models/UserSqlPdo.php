<?php

namespace App\Persistence\Models;

use App\Persistence\Connections\ConnectionInterface;
use Core\Interfaces\UserDao;
use Core\Entities\User;

final class UserSqlPdo implements UserDao
{
    private $fields = ['id', 'name', 'email', 'password', 'birthday'];
    public function __construct(
        private readonly ConnectionInterface $db
    ) {
    }

    public function saveUser(User $user): void
    {
        $values = [
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'password' => $user->password,
            'birthday' => $user->birthday,
        ];
        $this->db->insert('users', $values);
    }

    public function updateUser(array $user): void
    {
        if (!isset($user['id'])) {
            throw new \InvalidArgumentException('ID not found');
        }

        $idUser = $user['id'];
        unset($user['id']);

        $fields = array_intersect_key($user, array_flip($this->fields));
        $this->db->update('users', $fields, ['id' => $idUser]);
    }

    public function findUserById(string $idUser): array
    {
        try {
            return $this->db->find('users', $this->fields, ['id' => $idUser]);
        } catch (\Exception $e) {
            throw new \Exception('User not found');
        }
    }

    public function findUserByEmail(string $email): array
    {
        try {
            return $this->db->find('users', $this->fields, ['email' => $email]);
        } catch (\Exception $e) {
            throw new \Exception('User not found');
        }
    }

    public function getAllUsers(): array | null
    {
        return $this->db->select('users', $this->fields);
    }

    public function deleteUser(string $idUser): void
    {
        $rowsAffected = $this->db->delete('users', ['id' => $idUser]);
        if ($rowsAffected == 0) {
            throw new \Exception('Não foi possível realizar a exclusão');
        }
    }
}
