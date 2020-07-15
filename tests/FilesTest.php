<?php
/**
 * This file just is part of library.
 * PHP Version 7.2
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */
namespace FinderStrPos\Test;

use PHPUnit\Framework\TestCase;
use Zazliki\FinderStrPos\FileType\LocalFile;

class FilesTest extends TestCase
{
    public function testLocalFile()
    {
        $file = new LocalFile('examples/files/htmlfile.html');

        $this->assertSame('text/html', $file->getMimeType());
        $this->assertSame(445, $file->getSize());
    }
    
    public function testFtpFile()
    {
        // ...
    }
}