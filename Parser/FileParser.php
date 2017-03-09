<?php

namespace WebJaros\SymfonyLogReaderBundle\Parser;

use Symfony\Component\DependencyInjection\Container;

class FileParser
{
    /**
     * @var string
     */
    private $path = null;

    public function parseAndReturn()
    {
        $fileContents = file_get_contents($this->path);

        if (false === $fileContents) {
            throw new \Exception('Could not read the file');
        }

        $lines = explode(
            PHP_EOL,
            $fileContents
        );

        $this->emptyFile();

        $records = [];

        $lineParser = new LineParser();

        foreach ($lines as $key => $line) {
            if ('' == $line) {
                continue;
            }
            $records[] = $lineParser->setLine($line)->parse();
        }

        return $records;
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    public function setPath(string $path)
    {
        if (!file_exists($path)) {
            throw new \Exception('File not found: ' . $path);
        }

        $this->path = $path;
    }

    private function emptyFile()
    {
        if (false === file_put_contents($this->path, '', LOCK_EX)) {
            throw new \Exception('Could not write the file');
        }
    }

}