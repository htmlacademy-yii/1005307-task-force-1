<?php

$formatter = \Yii::$app->formatter;

use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="landing-task">
    <div class="landing-task-top task-<?= $model['category']['icon'] ?>"></div>
    <div class="landing-task-description">
        <h3><a href="<?= Url::to(['sign/']) ?>" class="link-regular"><?= $model['name'] ?></a></h3>
        <p><?= yii\helpers\StringHelper::truncate($model['description'], 90, '...') ?></p>
    </div>
    <div class="landing-task-info">
        <div class="task-info-left">
            <p><a href="<?= Url::to(['sign/']) ?>" class="link-regular"><?= $model['category']['name'] ?></a></p>
            <p><?= $formatter->asRelativeTime($model['dt_add']) ?></p>
        </div>
        <span><?= $model['budget'] ?> <b>₽</b></span>
    </div>
</div>
