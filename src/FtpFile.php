<?php
/**
 * This file just is part of library.
 * PHP Version 7.0
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */
namespace FinderStrPos;

class FtpFile implements File
{
    /**
     * Local filename
     * @var string 
     */
    private $filename;
    
    /**
     * Create a new temp file by copy from remote host
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $filepath
     * @throws \Exception
     */
    public function __construct(string $host, string $user, string $password, string $filepath)
    {
        $file = basename($filepath);
        $local = sys_get_temp_dir() . $file;
        
        $ftp_stream = ftp_connect($host);
        $login = ftp_login($ftp_stream, $user, $password);
        if (ftp_get($ftp_stream, $local, $filepath, FTP_BINARY)) {
            $this->filename = $local;
        } else {
            throw new \Exception('File transfer error');
        }
        
    }
    
    /**
     * Read file from copy on temp dir
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

