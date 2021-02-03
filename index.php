<?php
require 'task.php';

$idDoer = 1;
$idClient = 2;
$currentStatus = Task::STATUS_WORK;
$task = new Task($idDoer, $idClient, $currentStatus);
$isTaskStatusAll = $task->getStatusAll();
$isTaskActionsAll = $task->getActionsAll();
$isPosibleActionForClient = $task->getPosibleActionForClient($currentStatus);
$isPosibleActionsForDoer = $task->getPosibleActionForDoer(Task::STATUS_NEW);
$isPosibleStatus = $task->getPosibleStatus($currentStatus);
var_dump($isPosibleActionsForDoer); 
?>