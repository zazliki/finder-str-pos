<?php declare(strict_types=1);

/**
 * This file just is part of library.
 * PHP Version 7.2
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */

namespace Zazliki\FinderStrPos\FileType;

use Zazliki\FinderStrPos\Exception\FileException;

class FtpFile implements File
{
    /**
     * Filename of remote file in temp folder
     * @var string 
     */
    private $filename;
    
    /**
     * Create a new temp file by copy from remote host.
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $filepath
     *
     * @throws FileException
     */
    public function __construct(string $host, string $user, string $password, string $filepath)
    {
        $file = basename($filepath);
        $local = sys_get_temp_dir() . $file;
        
        $ftp_stream = ftp_connect($host);

        if (!ftp_login($ftp_stream, $user, $password)) {
            throw new FileException('Unable to connect via ftp');
        }

        if (!ftp_get($ftp_stream, $local, $filepath, FTP_BINARY)) {
            throw new FileException('File get via ftp error');
        }

        $this->filename = $local;
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
    
    function __destruct() {
        unlink($this->filename);
    }
}

