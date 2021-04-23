<?php
declare(strict_types=1);

namespace TaskForce\controllers;

use \SplFileObject;
use \RuntimeException;
use TaskForce\exceptions\FileSourceException;
use TaskForce\exceptions\GivenArgumentException;

final class CsvToSqlConverter
{
    private $csvName;
    private $sqlName;
    private $dataBaseTable;

    private $result = [];
    private $error = [];

    public function __construct(string $csvName)
    {
        if (!file_exists('data/' . $csvName)) {
            throw new FileSourceException("CSV файл '$csvName' либо не существует в директории 'data' либо не доступен для чтения");
        }

        $dataBaseTable = explode('.', $csvName)[0] ?? null;

        if (!$dataBaseTable) {
            throw new GivenArgumentException("Попытка присвоить dataBaseTable пустое значение");
        }

        $this->dataBaseTable = $dataBaseTable;
        $this->sqlName = 'data/' . 'sql/' . $this->dataBaseTable . '.sql';
        $this->csvName = 'data/' . $csvName;
// 		var_dump($dataBaseTable, $this->sqlName,$this->csvName);
    }

    public function convert(): void
    {     
       $csvFileObject = new SplFileObject($this->csvName);

        try {
 			var_dump($this->sqlName);
            $sqlFileObject = new SplFileObject($this->sqlName, "w");
        } catch (RuntimeException $exception) {
            throw new FileSourceException("Не удалось создать sql файл для записи");
        }

        $csvFileObject->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        $columns = $this->getColumns($csvFileObject);

        $firstValues = $this->arrayToString(
            $csvFileObject->fgetcsv()
        );

        $firstSqlLine = "INSERT INTO $this->dataBaseTable (" . $columns . ")\r\n" . 'VALUES ("' . $firstValues . '"),';
//		var_dump($firstSqlLine);
        $this->writeLine($sqlFileObject, $firstSqlLine);

        foreach ($this->getNextLine($csvFileObject) as $insertingValues) {
            $insertingValues = $this->arrayToString($insertingValues);
            $line = '("' . $insertingValues . '"),';
            $line = str_replace('"NULL"','NULL',$line);
            $this->writeLine($sqlFileObject, $line);
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

    private function getNextLine(SplFileObject $csvFileObject): iterable {
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
