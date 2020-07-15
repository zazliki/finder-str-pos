<?php
/**
 * This file just is part of library.
 * PHP Version 7.2
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */
namespace FinderStrPos\Test;

use PHPUnit\Framework\TestCase;
use Zazliki\FinderStrPos\Finder;
use Zazliki\FinderStrPos\FileType\LocalFile;

class FinderTest extends TestCase
{
    public function testLocalFile()
    {
        $finder = new Finder();
        $matches = $finder
            ->file(new LocalFile('examples/files/htmlfile.html'))
            ->setSubstring('<!DOCTYPE html>')
            ->execute()
        ;

        $this->assertNotEmpty($matches);
        $this->assertArrayHasKey('line', $matches[0]);
        $this->assertArrayHasKey('pos', $matches[0]);
        $this->assertSame(1, $matches[0]['line']);
        $this->assertSame(0, $matches[0]['pos']);
    }
}