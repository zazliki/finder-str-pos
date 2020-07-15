<?php declare(strict_types=1);

/**
 * This file just is part of library.
 * PHP Version 7.2
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */

namespace Zazliki\FinderStrPos\FileType;

use Exception;
use Zazliki\FinderStrPos\Exception\FileException;

class LocalFile implements File
{
    /**
     * Local filename
     * @var string
     */
    private $filename;

    /**
     * LocalFile constructor.
     *
     * @param string $filename
     *
     * @throws Exception
     */
    public function __construct(string $filename)
    {
        if (!file_exists($filename)) {
            throw new FileException('Local file not found');
        }

        $this->filename = $filename;
    }
    
    /**
     * @inheritDoc
     */
    public function read()
    {
        return @fopen($this->filename, 'r');
    }

    public function getMimeType(): string
    {
        return mime_content_type($this->filename);
    }

    public function getSize(): int
    {
        return filesize($this->filename);
    }
}
