<?php

namespace Core\ObjectValues;

final class Identifier
{
    private string $identifier;

    public function __construct(?string $value = null)
    {
        $this->identifier = is_null($value) ? $this->generateRandomBigIntId() : $value;
    }

    public function __toString(): string
    {
        return $this->identifier;
    }

    private function generateRandomBigIntId(): string
    {
        $id = strval(mt_rand(1, 9));
        for ($i = 1; $i <= 18; $i++) {
            $id .= strval(mt_rand(0, 9));
        }

        return $id;
    }

}
