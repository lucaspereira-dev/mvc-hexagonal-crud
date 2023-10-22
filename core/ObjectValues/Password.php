<?php

namespace Core\ObjectValues;

use Core\Exceptions\InvalidArgumentPassword;

final readonly class Password
{
    private string $password;
    public function __construct(
        string $password
    ) {
        if (strlen(trim($password)) === 0) {
            throw new InvalidArgumentPassword("Senha não pode ser vazio");
        }
        $this->password = $password;
    }

    /**
     * Compara o a senha hash passado com a senha criptografada da classe
     *
     * @throws InvalidArgumentPassword()
     * @return void
     */
    public function hashVerify(string $hashPassword): void
    {
        if (!password_verify($this->password, $hashPassword)) {
            throw new InvalidArgumentPassword();
        }
    }

    /**
     * Retorna a senha Criptografada
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->password;
        // return password_hash($this->password, PASSWORD_DEFAULT);
    }
    
}
