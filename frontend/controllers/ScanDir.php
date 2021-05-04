<?php

declare(strict_types=1);

namespace frontend\controllers;

//use TaskForce\exceptions\FileSourceException;

class ScanDir
{
    public function __construct(string $dirName)
    {
        if (!$dirName) {
      //      throw new FileSourceException("Папки '$dirName' нет");
        }
        $this->dirName = $dirName;
    }

    public function showFiles(string $fileExtension): array
    {
        return glob($this->dirName  . '*' . $fileExtension);
    }
}
