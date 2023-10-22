<?php

namespace Core\ObjectValues;

use Core\Exceptions\InvalidArgumentEmail;

final readonly class Email
{
    private string $email;
    public function __construct(string $email)
    {
        if (strlen(trim($email)) === 0) {
            throw new InvalidArgumentEmail("Email não pode ser vazio");
        } elseif (!$this->isValid($email)) {
            throw new InvalidArgumentEmail();
        }

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
    public static function isValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
