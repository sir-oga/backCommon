<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Helper;

class TokenHelper
{
    public static function generateToken(): string
    {
        try {
            return bin2hex(random_bytes(64)) . time();
        } catch (\Exception $ex) {
            throw new \RuntimeException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }
}
