<?php
/**
 * This file just is part of library.
 * PHP Version 7.0
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */
namespace FinderStrPos\Test;

use PHPUnit\Framework\TestCase;
use FinderStrPos\Finder;
use FinderStrPos\LocalFile;

class FinderTest extends TestCase
{
    public function testLocalFile()
    {
        $finder = new Finder('configs.yml');
        
        $this->assertTrue($this->arraysIsSimilar($finder->getConfig(), [
            'max-filesize' => 1000,
            'mime-type' => [
                'text/plain',
                'text/html',
                'text/css',
                'text/javascript'
            ]
        ]));
        
        
        $file = new LocalFile('examples/files/htmlfile.html');
        $finder->file($file);
        $finder->search('<!DOCTYPE html>');
        $this->assertTrue($this->arraysIsSimilar($finder->execute(), [
            [
                'string' => '<!DOCTYPE html>',
                'line' => 1,
                'pos' => 0
            ]
        ]));
        
    }
    
    private function arraysIsSimilar($a, $b)
    {
        if (count(array_diff_assoc($a, $b))) {
            return false;
        }
        
        foreach ($a as $k => $v) {
            if (!isset($b[$k]) || $v != $b[$k]) {
                return false;
            }
        }
        
        return true;
    }
}