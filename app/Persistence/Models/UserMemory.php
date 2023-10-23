<?php

namespace App\Persistence\Models;

use Core\Interfaces\UserDao;
use Core\Entities\User;
use Exception;

final class UserMemory implements UserDao
{
    private $users = [];

    public function saveUser(User $user): void
    {
        $values = [
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'password' => $user->password,
            'birthday' => $user->birthday
        ];
        array_push($this->users, $values);
    }

    public function updateUser(array $user): void
    {
        $data = $this->findUserById($user['id']);
        foreach($data as $key => &$value) {
            if(key_exists($key, $user)) {
                $value = $user[$key];
            }
        }

        $updateSuccess = false;
        foreach ($this->users as &$user) {
            if (strcmp($user['id'], $data['id']) !== 0) {
                continue;
            }
            $user = $data;
            $updateSuccess = true;
            break;
        }
        unset($user);

        if (!$updateSuccess) {
            throw new Exception('Não foi possível atualizar o usuário');
        }
    }

    public function findUserById(string $idUser): array | null
    {
        $user = array_filter($this->users, function ($user) use ($idUser) {
            return $user['id'] == $idUser;
        });

        return empty($user) ? null : current($user);
    }

    public function findUserByEmail(string $email): array | null
    {
        $user = array_filter($this->users, function ($user) use ($email) {
            return $user['email'] == $email;
        });

        return empty($user) ? null : current($user);
    }

    public function getAllUsers(): array | null
    {
        return $this->users;
    }

    public function deleteUser(string $idUser): void
    {
        $deletedSuccess = false;
        foreach ($this->users as $key => &$user) {
            if ($user['id'] != $idUser) {
                continue;
            }
            unset($this->users[$key]);
            $deletedSuccess = true;
            break;
        }
        unset($user);

        if (!$deletedSuccess) {
            throw new Exception('Não foi possível excluir o usuário');
        }
    }
}
