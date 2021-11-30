<?php

$formatter = \Yii::$app->formatter;

use yii\helpers\Url;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?= Url::to(['tasks/view/', 'id' => $model['id']]) ?>" class="link-regular">
            <h2><?= isset($model['name']) ? strip_tags($model['name']) : '' ?></h2>
        </a>
        <a href="<?= Url::to(['tasks/filter', 'category_id' => isset($model['cat_id']) ? strip_tags($model['cat_id']) : '']) ?>"
           class="link-regular">
            <?= isset($model['cat_name']) ? $model['cat_name'] : '' ?>
        </a>
    </div>
    <div
        class="new-task__icon new-task__icon--<?= isset($model['cat_icon']) ? strip_tags($model['cat_icon']) : '' ?>"></div>
    <p class="new-task_description">
        <?= isset($model['description']) ? htmlspecialchars($model['description']) : '' ?>
    </p>
        <b class="new-task__price new-task__price--<?= isset($model['cat_icon']) ? strip_tags($model['cat_icon']) : '' ?>">
            <?= isset($model['budget']) ? strip_tags($model['budget']) . '<b> ₽</b>' : '' ?>
        </b>
    <p class="new-task__place"><?= isset($model['address']) ? strip_tags($model['city']) . ' ' . strip_tags($model['address']) : 'Удаленная работа' ?> </p>
    <span class="new-task__time"><?= isset($model['dt_add']) ? $formatter->asRelativeTime($model['dt_add'], strftime("%F %T")) : '' ?></span>
</div>
