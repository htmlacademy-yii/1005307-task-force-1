<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\controllers\Task;

$idDoer                    = 2;
$idClient                  = 3;
$idUser                    = 3;
$currentStatus             = Task::STATUS_NEW;
$task                      = new Task($idDoer, $idClient, $idUser, $currentStatus);
$isTaskStatusAll           = $task->getStatusAll();
$isTaskActionsAll          = $task->getActionsAll();
$isPossibleActionsForUser  = $task->getActionsUser($currentStatus);
$isPossibleStatus          = $task->getPossibleStatus($currentStatus);

if ( $isPossibleActionsForUser ) var_dump($isPossibleActionsForUser->getTitle());
else var_dump('Для данного пользователя не возможных действий');


