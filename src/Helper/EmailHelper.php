<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Helper;

class EmailHelper
{
    private const DEFAULT_PROTOCOL = 'https://';

    public static function getDomain(string $email): ?string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        return explode('@', $email)[1];
    }

    public static function getDomainUrl(string $email): string
    {
        return self::DEFAULT_PROTOCOL . self::getDomain($email);
    }

    public static function getDomainName(string $email): ?string
    {
        $domain = self::getDomain($email);
        if (null === $domain) {
            return null;
        }
        $dotPosition = mb_strpos($domain, '.');
        $dotPosition = $dotPosition !== false ? $dotPosition : null;

        return ucfirst(mb_substr($domain, 0, $dotPosition));
    }
}
