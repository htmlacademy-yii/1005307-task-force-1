<?php
declare(strict_types = 1);
//set_include_path('class');
//spl_autoload_register();
require 'class/task.php';

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
