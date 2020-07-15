<?php declare(strict_types=1);

/**
 * This file just is part of library.
 * PHP Version 7.2
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */

namespace Zazliki\FinderStrPos\FileType;

interface File
{
    /**
     * @return bool|resource
     */
    public function read();

    public function getMimeType(): string;

    public function getSize(): int;
}

