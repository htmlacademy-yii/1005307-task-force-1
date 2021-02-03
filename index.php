<?php
set_include_path('class');
spl_autoload_register();

$idDoer = 1;
$idClient = 2;
$currentStatus = Task::STATUS_WORK;
$task = new Task($idDoer, $idClient, $currentStatus);
$isTaskStatusAll = $task->getStatusAll();
$isTaskActionsAll = $task->getActionsAll();
$isPosibleActionForClient = $task->getPosibleActionForClient($currentStatus);
$isPosibleActionsForDoer = $task->getPosibleActionForDoer(Task::STATUS_NEW);
$isPosibleStatus = $task->getPosibleStatus($currentStatus);
var_dump($isPosibleActionForClient);
?>