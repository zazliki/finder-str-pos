<?php
require '../vendor/autoload.php';

use Zazliki\FinderStrPos\Finder;
use Zazliki\FinderStrPos\FileType\LocalFile;

$finder = new Finder();
$finder->file(new LocalFile('files/htmlfile.html'));

// execute simple substring
$matches = $finder
    ->setSubstring('TODO')
    ->execute()
;
print_r($matches);

// execute by user func
$matches = $finder
    ->setSubstring(md5('<html>'))
    ->setSearchCallback(function($str, $substring) {
        return md5($str) === $substring;
    })
    ->execute();
;
print_r($matches);