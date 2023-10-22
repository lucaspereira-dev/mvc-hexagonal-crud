<?php

namespace Core\Exceptions;

use InvalidArgumentException;

final class InvalidArgumentUserName extends InvalidArgumentException
{
    private const DEFAULT_MESSAGE = 'O nome de usuário não pode estar vazio';
    public function __construct(
        private string $messageError = self::DEFAULT_MESSAGE,
        private int $codeError = 400,
        private $previousError = null
    ) {
        parent::__construct($this->messageError, $this->codeError, $this->previousError);
    }
    public function __toString()
    {
        return __CLASS__ . ": [{$this->codeError}]: {$this->messageError}\n";
    }
}
