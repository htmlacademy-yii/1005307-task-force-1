<?php

$formatter = \Yii::$app->formatter;

use yii\helpers\Url;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?= Url::to(['tasks/view/', 'id' => $model['id']]) ?>" class="link-regular">
            <h2><?= strip_tags($model['name']) ?></h2>
        </a>
        <a href="<?= Url::to(['tasks/filter', 'category_id' => $model['cat_id']]) ?>" class="link-regular">
            <?= $model['cat_name'] ?>
        </a>
    </div>
    <div class="new-task__icon new-task__icon--<?= $model['cat_icon'] ?>"></div>
    <p class="new-task_description">
        <?= htmlspecialchars($model['description']) ?>
    </p>
    <b class="new-task__price new-task__price--<?= $model['category']['icon'] ?>">
        <?= strip_tags($model['budget']) ?> <b> ₽</b>
    </b>
    <p class="new-task__place"><?= $model['address'] ? strip_tags($model['address']) : 'Удаленная работа' ?> </p>
    <span class="new-task__time"><?= $formatter->asRelativeTime($model['dt_add'], strftime("%F %T")) ?></span>
</div>
