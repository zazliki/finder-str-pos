<?php
/**
 * This file just is part of library.
 * PHP Version 7.0
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */
namespace FinderStrPos;

interface File
{
    /**
     * Return fopen resource
     * @return resource | false
     */
    public function read();
    
    /**
     * Return mime type of file
     * @return string
     */
    public function getMimeType(): string;
    
    /**
     * Return filesize
     * @return int
     */
    public function getSize(): int;
}

