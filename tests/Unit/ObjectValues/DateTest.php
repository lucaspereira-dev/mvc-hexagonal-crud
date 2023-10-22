<?php

namespace Tests\Unit\ObjectValues;

use \InvalidArgumentException;
use Core\ObjectValues\Date;
use PHPUnit\Framework\TestCase;

final class DateTest extends TestCase
{

    /**
     * Deve-se criar objeto data com sucesso
     * @test
     */
    public function ShouldCreatedObjectDateWithSuccess(): void
    {
        $dateFormatYYYYmmdd = new Date('2023-01-01');
        $dateFormatDDmmyyyy = new Date('31/12/2022');
        $this->assertInstanceOf(Date::class, $dateFormatYYYYmmdd);
        $this->assertInstanceOf(Date::class, $dateFormatDDmmyyyy);
        $this->assertEquals('2023-01-01', $dateFormatYYYYmmdd);
        $this->assertEquals('31/12/2022', $dateFormatDDmmyyyy->getByFormat('d/m/Y'));
    }

    /**
     * Não deve criar data em formato incorreto
     * @test
     */
    public function ShouldNotCreateObjectInIncorrectFormat(): void
    {
        $this->expectExceptionMessage('Data informada não é valida');
        (new Date('2023-13-01'));
    }
}
