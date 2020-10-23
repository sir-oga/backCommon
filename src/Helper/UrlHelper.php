<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Helper;

use Symfony\Component\HttpFoundation\Request;

class UrlHelper
{
    public function getSchemeAndHost(string $url): ?string
    {
        $urlParsed = parse_url($url);
        if (!is_array($urlParsed)) {
            return null;
        }

        return sprintf('%s://%s', $urlParsed['scheme'] ?? '', $urlParsed['host'] ?? '');
    }

    public static function getSiteDomain(Request $request): string
    {
        return $request->getScheme() . '://' . str_replace(
            ['api.', 'api-', 'admin-'],
            ['', '', ''],
            $request->getHost()
        );
    }

    public function getHost(string $url): ?string
    {
        $urlParsed = parse_url($url);
        if (!is_array($urlParsed)) {
            return null;
        }

        return $urlParsed['host'] ?? null;
    }

    /**
     * @param string $url
     * @return array<string>
     */
    public function getQueryParams(string $url): array
    {
        $urlParsed = parse_url($url);
        $queryParams = [];
        if (is_array($urlParsed) && !empty($urlParsed['query'])) {
            $queries = explode('&', $urlParsed['query'] ?? '');
            foreach ($queries as $query) {
                $query = explode('=', $query);
                $queryParams[$query[0]] = $query[1] ?? '';
            }
        }

        return $queryParams;
    }

    public function getQueryParam(string $url, string $param): ?string
    {
        return $this->getQueryParams($url)[$param] ?? null;
    }
}
