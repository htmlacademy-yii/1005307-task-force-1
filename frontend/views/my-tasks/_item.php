<?php

$formatter = \Yii::$app->formatter;

use yii\helpers\Url;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="#" class="link-regular"><h2><?= $model['name'] ?></h2></a>
        <a  class="new-task__type link-regular" href="<?= Url::to(['tasks/filter', 'category_id' => $model['category_id']]) ?>"><p><?=$model['category']['name']?></p></a>
    </div>
    <div class="task-status done-status"><?= $model['status_task'] ?></div>
    <p class="new-task_description">
        <?= $model['description'] ?>
    </p>
    <div class="feedback-card__top ">
        <a href="#"><img src="./img/man-glasses.jpg" width="36" height="36"></a>
        <div class="feedback-card__top--name my-list__bottom">
            <p class="link-name"><a href="#" class="link-regular">Астахов Павел</a></p>
            <a href="#" class="my-list__bottom-chat  my-list__bottom-chat--new"><b>3</b></a>
            <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
            <b>4.25</b>
        </div>
    </div>
</div>
