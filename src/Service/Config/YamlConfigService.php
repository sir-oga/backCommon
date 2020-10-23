<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Service\Config;

use Symfony\Component\Yaml\Yaml;

class YamlConfigService
{
    /**
     * @var string
     */
    private $projectDir;

    public function __construct(
        string $projectDir
    ) {
        $this->projectDir = $projectDir;
    }

    /**
     * @param string $config
     * @return mixed
     */
    public function get(string $config)
    {
        $path = $this->projectDir . '/config/cfg/' . $config . '.yaml';

        return Yaml::parseFile($path, Yaml::PARSE_CONSTANT);
    }

    /**
     * @param string $config
     * @param string|null $key
     * @return mixed|null
     */
    public function getByKey(string $config, string $key = null)
    {
        return $this->get($config)[$key] ?? null;
    }
}
