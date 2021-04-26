<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\controllers\CsvToSqlConverter;
use TaskForce\controllers\ScanDir;

use TaskForce\exceptions\StatusException as StatusException;

$dir = 'data/';
$csvExtension = '.csv';
$dirSql = 'data/sql/';
$csvFiles = new ScanDir($dir);
$csvFilesList = $csvFiles->showFiles($csvExtension);

$csvConverter = new CsvToSqlConverter($dirSql);

foreach ($csvFilesList as $csvFile) {
    $csvConverter->convert($csvFile);
}


//echo 'finished';
/*
use TaskForce\controllers\Task;
use TaskForce\exceptions\StatusException as StatusException;


$idDoer = 2;
$idClient = 3;
$idUser = 3;

$currentStatus = Task::STATUS_NEW;

try {
$task = new Task($idDoer, $idClient, $idUser, $currentStatus);

$isTaskStatusAll = $task->getStatusAll();
$isTaskActionsAll = $task->getActionsAll();

try {
    $isPossibleActionsForUser = $task->getActionsUser(Task::STATUS_NEW);
    if ($isPossibleActionsForUser) {
        var_dump($isPossibleActionsForUser->getTitle());
    } else {
        var_dump('Для данного пользователя нет возможных действий');
    }
} catch (StatusException $e) {
    var_dump('Выброшено исключение:' . $e->getMessage(), "\n");
}

try {
    $isPossibleStatus = $task->getPossibleStatus(Task::STATUS_WORK);
    var_dump($isPossibleStatus);
} catch (StatusException $e) {
    var_dump('Выброшено исключение:' . $e->getMessage(), "\n");
}
} catch (StatusException $e) {
var_dump('Выброшено исключение:' . $e->getMessage(), "\n");
}
*/;
