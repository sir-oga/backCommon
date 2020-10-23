<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Exception;

use Exception;
use Throwable;

class DataValidationException extends Exception
{
    /**
     * @var array<array>
     */
    protected $errors;

    /**
     * DataValidationException constructor.
     * @param string $message
     * @param array<mixed> $errors
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', array $errors = [], int $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array<array>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
