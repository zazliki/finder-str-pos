<?php
require '../vendor/autoload.php';

use FinderStrPos\Finder;
use FinderStrPos\LocalFile;

$file = new LocalFile('files/htmlfile.html');
$finder = new Finder('../configs.yml');
$finder->file($file);

// execute simple substring
$finder->search('TODO');
$matches = $finder->execute();
print_r($matches);

// execute by user func
$finder->callback(function($str) {
    return md5($str);
});
$finder->search(md5('<html>'));
$matches = $finder->execute();
print_r($matches);