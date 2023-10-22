<?php

namespace Core\Entities;

use Core\Exceptions\InvalidArgumentPassword;
use Core\Exceptions\InvalidArgumentUserName;
use Core\Exceptions\InvalidArgumentEmail;
use Core\Exceptions\UserException;
use Core\ObjectValues\Identifier;
use Core\ObjectValues\Password;
use InvalidArgumentException;
use Core\ObjectValues\Email;
use Core\ObjectValues\Name;
use Core\ObjectValues\Date;

final class User
{
    public readonly Identifier $id;
    public readonly Name $name;
    public readonly Email $email;
    public readonly Password $password;
    public readonly Date $birthday;
    public function __construct(
        ?string $id,
        string $name,
        string $email,
        string $password,
        string $birthday
    ) {
        $this->createValueInstanceAndValid($name,$email, $password, $birthday);
        $this->id = new Identifier($id);
    }

    private function createValueInstanceAndValid(
        string $name,
        string $email,
        string $password,
        string $birthday
    ): void
    {
        $errors = [];

        try {
            $this->name = new Name($name);
        } catch (InvalidArgumentUserName $e) {
            $errors['name'] = $e->getMessage();
        }

        try {
            $this->email = new Email($email);
        } catch (InvalidArgumentEmail $e) {
            $errors['email'] = $e->getMessage();
        }

        try {
            $this->password = new Password($password);
        } catch (InvalidArgumentPassword $e) {
            $errors['password'] = $e->getMessage();
        }

        try {
            $this->birthday = new Date($birthday);
        } catch (InvalidArgumentException $e) {
            $errors['birthday'] = $e->getMessage();
        }

        
        if (!empty($errors)) {
            throw new UserException(json_encode(['errors' => $errors]));
        }
    }

}
