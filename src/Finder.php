<?php
/**
 * FInderStrPos - Simple finder the line and position of substing in file
 * PHP Version 7.0
 * 
 * @see https://github.com/zazliki/finder-str-pos
 */
namespace FinderStrPos;

use Symfony\Component\Yaml\Yaml;
use Symfone\Component\Yaml\Exception\ParseException;

class Finder
{
    /**
     * @var File $file          Object of file
     * @var array $config       Config from Yaml-file
     * @var string $substring   Substring of query
     * @var callback callable   User func
     */
    private $file,
            $config,
            $substring,
            $callback;
    
    /**
     * Set config by passed filename
     * @param string $config
     */
    public function __construct(string $config)
    {
        try {
            $this->config = Yaml::parseFile($config);
        } catch (ParseException $exception) {
            printf('Error to parse the YAML string: %s', $exception->getMessage());
        }
    }
    
    /**
     * Return array of config
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
    
    /**
     * Check and set object of file
     * @param \FinderStrPos\File $file
     */
    public function file(File $file)
    {
        $this->file = null;
        if (in_array($file->getMimeType(), $this->config['mime-type']) && $file->getSize() <= $this->config['max-filesize']) {
            $this->file = $file;
        }
    }
    
    /**
     * Set substring for search
     * @param string $substring
     */
    public function search(string $substring)
    {
        $this->substring = $substring;
    }
    
    /**
     * Add user func
     * @param callable $func
     */
    public function callback(callable $func)
    {
        $this->callback = $func;
    }
    
    /**
     * Execute matches by substring from file
     * @return array
     */
    public function execute(): array
    {
        $matches = [];
        if ($handle = $this->file->read()) {
            $line = 0;
            while (!feof($handle)) {
                $line += 1;
                $string = str_replace("\n", "", fgets($handle));
                if (is_callable($this->callback)) {
                    $result = call_user_func($this->callback, $string);
                    if ($result == $this->substring) {
                        $matches[] = compact('string', 'line', 'result');
                    }
                } else {
                    if (($pos = strpos($string, $this->substring)) !== FALSE) {
                        $matches[] = compact('string', 'line', 'pos');
                    }
                }
            }
            fclose($handle);
        }
        return $matches;
    }
    
}

