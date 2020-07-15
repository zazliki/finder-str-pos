<?php declare(strict_types=1);

/**
 * This file just is part of library.
 * PHP Version 7.2
 *
 * @see https://github.com/zazliki/finder-str-pos
 */

namespace Zazliki\FinderStrPos;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Zazliki\FinderStrPos\Exception\ConfigException;

final class Config
{
    /**
     * @var mixed[]
     */
    private $config;

    /**
     * Config constructor.
     *
     * @param string|null $configPath
     *
     * @throws ConfigException
     */
    public function __construct(string $configPath = null)
    {
        if (null === $configPath) {
            $configPath = $this->getDefaultConfigPath();
        }

        try {
            $this->config = Yaml::parseFile($configPath);
        } catch (ParseException $parseException) {
            throw new ConfigException('Parse error yaml config file');
        }
    }

    /**
     * @return string[]
     */
    public function allowedMimeTypes(): array
    {
        return $this->config['mime-types'] ?? [];
    }

    public function allowedMaxSize(): int
    {
        return $this->config['max-filesize'] ?? 0;
    }

    public function get(): array
    {
        return $this->config;
    }

    private function getDefaultConfigPath(): string
    {
        return '../configs.yml';
    }
}