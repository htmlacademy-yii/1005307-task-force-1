<?php
declare(strict_types = 1);
spl_autoload_register(function ($class) {
    require_once 'src/base/' . $class . '.php';
});


$idDoer                   = 1;
$idClient                 = 2;
$currentStatus            = Task::STATUS_WORK;
$task                     = new Task($idDoer, $idClient, $currentStatus);
$isTaskStatusAll          = $task->getStatusAll();
$isTaskActionsAll         = $task->getActionsAll();
$isPossibleActionForClient = $task->getPossibleActionForClient($currentStatus);
$isPossibleActionsForDoer  = $task->getPossibleActionForDoer(Task::STATUS_NEW);
$isPossibleStatus          = $task->getPossibleStatus($currentStatus);
var_dump($isPossibleActionForClient);
