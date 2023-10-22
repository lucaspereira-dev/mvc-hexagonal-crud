<?php

namespace Core\ObjectValues;

use Core\Exceptions\InvalidArgumentUserName;

final readonly class Name
{
    private string $username;

    public function __construct(string $username)
    {
        $this->validateUsername($username);
        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    private function validateUsername(string $username)
    {
        if (strlen(trim($username)) === 0) {
            throw new InvalidArgumentUserName();
        }
    }
}
