<?php

declare(strict_types=1);

namespace Cms\Backend\Common\DTO\Output;

use JsonSerializable;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(required={"code", "message", "errors"}, type="object")
 */
class ErrorDTO implements JsonSerializable
{
    /**
     * @SWG\Property(
     *     description="Error code",
     *     type="integer"
     * )
     * @var int
     */
    private $code;

    /**
     * @SWG\Property(
     *     description="Error message",
     *     type="string",
     *
     * )
     * @var string
     */
    private $message;

    /**
     * @SWG\Property(
     *     description="Errors",
     *     type="array",
     *     @SWG\Items(
     *         type="object"
     *     )
     * )
     * @var array<string, string>
     */
    private $errors;

    /**
     * @param int $code
     * @param string $message
     * @param array<string, string> $errors
     */
    public function __construct(int $code, string $message, array $errors)
    {
        $this->code = $code;
        $this->message = $message;
        $this->errors = $errors;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'errors' => $this->errors,
        ];
    }
}
