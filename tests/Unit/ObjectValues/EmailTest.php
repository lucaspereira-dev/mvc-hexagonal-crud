<?php

namespace Tests\Unit\ObjectValues;

use Core\Exceptions\InvalidArgumentEmail;
use Core\ObjectValues\Email;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{

    /**
     * Deve-se criar e-mail de objeto com sucesso
     * @test
     */
    public function ShouldCreatedObjectEmailWithSuccess(): void
    {
        $email = new Email('lucas.pereira@testes.com.br');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals('lucas.pereira@testes.com.br', $email);
    }

    /**
     * Não deve criar objeto de e-mail em formato incorreto
     * @test
     */
    public function ShouldNotCreateEmailObjectIncorrectFormat(): void
    {
        $this->expectException(InvalidArgumentEmail::class);
        $this->expectExceptionMessage('Argumento de e-mail inválido');
        (new Email('lucas.pereira#testes.com.br'));
    }
}
