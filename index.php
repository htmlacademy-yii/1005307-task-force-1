<?php
//$is_auth = rand(0, 1);
require 'task.php';

$idDoer = 1;
$idClient = 1;
$currentStatus = 'STATUS_NEW';
$task = new Task();
$isTaskStatusAll = $task->getStatusAll();
$isTaskActionsAll = $task->getActionsAll();
$isPosibleActionForClient = $task->getPosibleActionForClient('STATUS_NEW');
$isPosibleActionsForDoer = $task->getPosibleActionForDoer('STATUS_NEW');
var_dump($isTaskActionsAll);
var_dump($isTaskStatusAll);
var_dump($isPosibleActionsForClient);
var_dump($isPosibleActionsForDoer);
//echo($isTaskStatusAll);

//$user_name = ''; // укажите здесь ваше имя
/*
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}


require_once 'task.php';

$status = ['new', 'cancelled', 'in work', 'done', 'failed'];
$actions = ['new', 'cancelled', 'in work', 'done', 'failed'];

// подключаем шаблон главной страницы
$page_content = include_template('view.php');

$layout_content = include_template(
    'layout.php',
    ['content' => $page_content]
);
print($layout_content);*/
?>