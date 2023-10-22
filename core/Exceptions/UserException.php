<?php

namespace Core\Exceptions;

use Exception;

final class UserException extends Exception
{
    private const DEFAULT_MESSAGE = 'Error ao criar usuário';
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
