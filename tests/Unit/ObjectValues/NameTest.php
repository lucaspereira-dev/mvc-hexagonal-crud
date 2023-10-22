<?php

namespace Tests\Unit\ObjectValues;

use Core\Exceptions\InvalidArgumentUserName;
use Core\ObjectValues\Name;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{

    /**
     * Deve-se criar e-mail de objeto com sucesso
     * @test
     */
    public function ShouldCreatedObjectNameWithSuccess(): void
    {
        $inputPass = 'Lucas Pereira';
        $name = new Name($inputPass);
        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals($inputPass, $name);
    }

    /**
     * Não deve criar objeto de e-mail em formato incorreto
     * @test
     */
    public function ShouldNotCreateNameObjectIncorrectFormat(): void
    {
        $this->expectException(InvalidArgumentUserName::class);
        $this->expectExceptionMessage('O nome de usuário não pode estar vazio');
        (new Name('  '));
    }
}
