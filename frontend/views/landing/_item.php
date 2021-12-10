<?php

$formatter = \Yii::$app->formatter;

use yii\helpers\Url;

?>

<div class="landing-task">
        <div class="landing-task-top task-<?= isset($model['category']['icon']) ? $model['category']['icon'] : '' ?>"></div>
        <div class="landing-task-description">
            <h3><a href="<?= Url::to(['sign/']) ?>" class="link-regular"><?= isset($model['name']) ? strip_tags($model['name']) : '' ?></a></h3>
            <p><?= isset($model->description) ? yii\helpers\StringHelper::truncate(htmlspecialchars($model['description']), 90, '...') : '' ?></p>
        </div>
        <div class="landing-task-info">
            <div class="task-info-left">
                <p><a href="<?= Url::to(['sign/']) ?>" class="link-regular"><?= isset($model->category->name) ? $model->category->name : '' ?></a></p>
                <p><?= isset($model->dt_add) ? $formatter->asRelativeTime($model->dt_add) : '' ?></p>
            </div>
                <span><?= isset($model->budget) ? strip_tags($model->budget) . '<b>₽</b>' : '' ?> </span>
        </div>
</div>
