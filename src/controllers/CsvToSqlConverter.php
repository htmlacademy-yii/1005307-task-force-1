<?php
declare(strict_types=1);

namespace TaskForce\controllers;

use \SplFileObject;
use \RuntimeException;
use TaskForce\exceptions\FileSourceException;
use TaskForce\exceptions\GivenArgumentException;

final class CsvToSqlConverter
{

    public function __construct($dir)
    {
        if (!file_exists($dir)) {
            throw new FileSourceException("Папка '$dir' либо не существует, либо не доступна для чтения");
        }
        $this->dir = $dir;
    }

    public function convert($csvName): void
    {
        $csvFileObject = new SplFileObject($csvName);
        try {
            $namePath = pathinfo($csvName, PATHINFO_FILENAME);
            $fileNames = explode('.', $namePath)[0] ?? null;
            $fileName = $this->dir . $fileNames . '.sql';
            $sqlFileObject = new SplFileObject($fileName, "w");

        } catch (RuntimeException $exception) {
            throw new FileSourceException("Не удалось создать sql файл для записи");
        }

        $csvFileObject->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        $columns = $this->getColumns($csvFileObject);

        $firstValues = $this->arrayToString(
            $csvFileObject->fgetcsv()
        );

        $firstSqlLine = "INSERT INTO $fileNames (" . $columns . ")\r\n" . 'VALUES ("' . $firstValues . '"),';
        $this->writeLine($sqlFileObject, $firstSqlLine);

        foreach ($this->getNextLine($csvFileObject) as $insertingValues) {
            if ($insertingValues) {
                $insertingValues = $this->arrayToString($insertingValues);

                $line = '("' . $insertingValues . '"),';
                $line = str_replace('"NULL"', 'NULL', $line);
                $this->writeLine($sqlFileObject, $line);
            }
        }

        $sqlFileObject->fseek(-3, SEEK_END);
        $sqlFileObject->fwrite(';');
    }

    private
    function getColumns(SplFileObject $csvFileObject): string
    {
        $csvFileObject->rewind();
        $data = $csvFileObject->fgetcsv();
        $columns = array_shift($data);

        foreach ($data as $value) {
            $columns .= ", $value";
        }

        return $columns;
    }

    private function getNextLine(SplFileObject $csvFileObject): iterable
    {
        while (!$csvFileObject->eof()) {
            yield $csvFileObject->fgetcsv();
        }
    }

    private function writeLine(SplFileObject $sqlFileObject, string $line): void
    {
        $sqlFileObject->fwrite("$line\r\n");
    }

    private function arrayToString(array $array): string
    {
        return implode('", "', $array);
    }
}
