<?php

$formatter = \Yii::$app->formatter;

use yii\helpers\Url;
use yii\helpers\Html;

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
        <?php if ($user->user_role == 'client'): ?>
        <a href="#"><?= $model['doer']['avatar']
                ? Html::img(Yii::$app->request->baseUrl . '/img/' . $model['doer']['avatar'], ['width' => '55', 'height' => '55'])
                : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '55', 'height' => '55']) ?>
        </a>
        <div class="feedback-card__top--name my-list__bottom">
            <p class="link-name"><a href="#" class="link-regular"><?= $model['doer']['name'] ?></a></p>
            <a href="#" class="my-list__bottom-chat  my-list__bottom-chat--new"><b>3</b></a>
            <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
            <b>4.25</b>
        </div>
    <?php endif;?>
    </div>
</div>
