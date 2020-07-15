<?php
/**
 * This file just is part of library.
 * PHP Version 7.2
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */
namespace FinderStrPos\Test;

use PHPUnit\Framework\TestCase;
use Zazliki\FinderStrPos\Config;

class FinderTest extends TestCase
{
    public function testDefaultConfig()
    {
        $config = new Config();

        $this->assertSame(1000, $config->allowedMaxSize());
        $this->assertContains('text/html', $config->allowedMimeTypes());
    }
}