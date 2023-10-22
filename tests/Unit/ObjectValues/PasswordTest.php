<?php

namespace Tests\Unit\ObjectValues;

use Core\Exceptions\InvalidArgumentPassword;
use Core\ObjectValues\Password;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{

    /**
     * Deve-se criar e-mail de objeto com sucesso
     * @test
     */
    public function ShouldCreatedObjectPasswordWithSuccess(): void
    {
        $inputPass = 'eusouumasenhafrase@1234#blablabla';
        $password = new Password($inputPass);
        $this->assertInstanceOf(Password::class, $password);
        $this->assertEquals($inputPass, $password);
    }

    /**
     * Não deve criar objeto de e-mail em formato incorreto
     * @test
     */
    public function ShouldNotCreatePasswordObjectIncorrectFormat(): void
    {
        $this->expectException(InvalidArgumentPassword::class);
        $this->expectExceptionMessage('Senha não pode ser vazio');
        (new Password('  '));
    }
}
