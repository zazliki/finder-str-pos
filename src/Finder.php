<?php declare(strict_types=1);

/**
 * FinderStrPos - Simple finder the line and position of substing in file
 * PHP Version 7.2
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */

namespace Zazliki\FinderStrPos;

use Zazliki\FinderStrPos\Exception\FinderException;
use Zazliki\FinderStrPos\FileType\File;

class Finder
{
    /**
     * @var File
     */
    private $file;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $substring;

    /**
     * @var callable
     */
    private $callback;

    public function __construct()
    {
        $this->setConfig(new Config());
    }

    /**
     * @return mixed[]
     */
    public function getConfig(): array
    {
        return $this->config->get();
    }

    public function setConfig(Config $config): self
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param File $file
     *
     * @return Finder
     *
     * @throws FinderException
     */
    public function file(File $file): self
    {
        if (!in_array($file->getMimeType(), $this->config->allowedMimeTypes())) {
            throw new FinderException('Invalid mime types');
        }

        if ($file->getSize() > $this->config->allowedMaxSize()) {
            throw new FinderException('File is to large');
        }

        $this->file = $file;

        return $this;
    }

    public function setSubstring(string $substring)
    {
        $this->substring = $substring;

        return $this;
    }

    public function setSearchCallback(?callable $func)
    {
        $this->callback = $func;

        return $this;
    }
    
    public function execute(): array
    {
        $matches = [];
        if ($handle = $this->file->read()) {
            $line = 0;
            while (!feof($handle)) {
                $line += 1;
                $string = str_replace("\n", "", fgets($handle));

                $searchFunc = function ($string, $substring) {
                    return strpos($string, $substring);
                };

                if (is_callable($this->callback)) {
                    $searchFunc = $this->callback;
                }

                if (false !== $result = call_user_func($searchFunc, $string, $this->substring)) {
                    $matches[] = [
                        'line' => $line,
                        'pos' => $result,
                        'string' => $string,
                    ];
                }
            }

            fclose($handle);
        }

        return $matches;
    }
}

