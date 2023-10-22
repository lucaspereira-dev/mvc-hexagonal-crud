<?php

namespace Tests\Unit\ObjectValues;

use Core\ObjectValues\Identifier;
use PHPUnit\Framework\TestCase;

final class IdentifierTest extends TestCase
{

    /**
     * Deveria criar um Identificador com parâmetro informado
     * @test
     */
    public function ShouldCreateIdentifierWithTheInformedParameter(): void
    {
        $identifierPersistence = '123547';
        $identifier = new Identifier($identifierPersistence);
        $this->assertInstanceOf(Identifier::class, $identifier);
        $this->assertEquals($identifierPersistence, $identifier);
    }

    /**
     * Não deve criar objeto de e-mail em formato incorreto
     * @test
     */
    public function ShouldCreateIdentifierRandom(): void
    {
        $identifier = new Identifier();
        $this->assertNotEmpty(Identifier::class, $identifier);
    }
}
