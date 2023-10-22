<?php

namespace Core\ObjectValues;

use DateTime;
use InvalidArgumentException;

final readonly class Date
{
    const DEFAULT_FORMAT = "Y-m-d";
    private DateTime $date;

    public function __construct(string $date)
    {
        $date = $this->parseDate($date);
        if (is_null($date)) {
            throw new InvalidArgumentException("Data informada não é valida");
        }
        $this->date = $date;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getByFormat(string $format): string
    {
        return $this->date->format($format);
    }

    public function __toString(): string
    {
        return $this->getByFormat(self::DEFAULT_FORMAT);
    }

    private function parseDate(string $date): ?DateTime
    {
        $parsedDate = date_create_from_format('d/m/Y', $date);
        if (!$parsedDate) {
            $parsedDate = date_create_from_format('Y-m-d', $date);
        }

        if (
            $parsedDate instanceof DateTime &&
            ($date === $parsedDate->format('d/m/Y') || $date === $parsedDate->format('Y-m-d'))
        ) {
            return $parsedDate;
        }

        return null;
    }
}
