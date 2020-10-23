<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Helper;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorHelper
{
    public const MESSAGE_VALIDATION_ERROR = 'Validation failed';

    /**
     * @param ConstraintViolationListInterface<mixed> $errorsRow
     * @return array<array>
     */
    public static function getValidationErrors(ConstraintViolationListInterface $errorsRow): array
    {
        $errors = [];
        foreach ($errorsRow as $violation) {
            $key = $violation->getPropertyPath();
            if (isset($errors[$key])) {
                continue;
            }
            $errors[$key] = $violation->getMessage();
        }

        return $errors;
    }

    /**
     * @param string $field
     * @param string $message
     * @return array<mixed>
     */
    public static function getCustomErrors(string $field, string $message = ''): array
    {
        return [
            $field => $message,
        ];
    }
}
