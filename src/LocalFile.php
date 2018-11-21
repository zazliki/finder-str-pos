<?php
/**
 * This file just is part of library.
 * PHP Version 7.0
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */
namespace FinderStrPos;

class LocalFile implements File
{
    /**
     * Local filename
     * @var string
     */
    private $filename;
    
    /**
     * Create a new local file
     * @param string $filename
     * @throws \Exception
     */
    public function __construct(string $filename)
    {
        if (file_exists($filename)) {
            $this->filename = $filename;
        } else {
            throw new \Exception('File not found');
        }
    }
    
    /**
     * Read file from local
     * @return resource | false
     */
    public function read()
    {
        return @fopen($this->filename, 'r');
    }
    
    /**
     * Get mime type of file
     * @return string
     */
    public function getMimeType(): string
    {
        return mime_content_type($this->filename);
    }
    
    /**
     * Get filesize
     * @return int
     */
    public function getSize(): int
    {
        return filesize($this->filename);
    }
}
