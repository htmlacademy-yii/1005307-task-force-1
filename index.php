<?php
require 'task.php';

$idDoer = 1;
$idClient = 1;
$currentStatus = 'STATUS_NEW';
$task = new Task();
$isTaskStatusAll = $task->getStatusAll();
$isTaskActionsAll = $task->getActionsAll();
$isPosibleActionForClient = $task->getPosibleActionForClient('STATUS_NEW');
$isPosibleActionsForDoer = $task->getPosibleActionForDoer('STATUS_NEW');
?>
