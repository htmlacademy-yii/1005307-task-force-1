<?php

$formatter = \Yii::$app->formatter;

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?= Url::to(['tasks/view/', 'id' => $model['id']]) ?>" class="link-regular">
            <h2><?= $model['name'] ?></h2></a>
        <a href="<?= Url::to(['tasks/index', ['categories_id' => $model['category_id']]]) ?>" class="link-regular"><?= $model['category']['name'] ?></a>
    </div>
    <div class="new-task__icon new-task__icon--<?= $model['category']['icon'] ?>"></div>
    <p class="new-task_description">
        <?= $model['description'] ?>
    </p>
    <b class="new-task__price new-task__price--<?= $model['category']['icon'] ?>">
        <?= $model['budget'] ?> <b> ₽</b></b>
    <p class="new-task__place"><?= $model['address'] ? $model['address'] : 'Удаленная работа' ?> </p>
    <span class="new-task__time"><?= $formatter->asRelativeTime($model['dt_add'], strftime("%F %T")) ?></span>
</div>
