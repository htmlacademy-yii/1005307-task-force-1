<?php

$formatter = \Yii::$app->formatter;

use yii\helpers\Url;
use yii\helpers\Html;

$user = \Yii::$app->user->getIdentity();

$isClient = false;

if ($user['user_role'] == 'client') {
    $isClient = true;
}
$isClient ? $user_show = $model['doer'] : $user_show = $model['client'];
?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?= Url::to(['tasks/view/', 'id' => $model['id']]) ?>" class="link-regular"><h2><?= $model['name'] ?></h2></a>
        <a class="new-task__type link-regular"
           href="<?= Url::to(['tasks/filter', 'category_id' => $model['category_id']]) ?>">
            <p><?= $model['category']['name'] ?></p></a>
    </div>
    <div
        class="task-status <?= $formatter->getStatusColor($model['status_task']) ?>-status"><?= $model['status_task'] ?></div>
    <p class="new-task_description">
        <?= $model['description'] ?>
    </p>
    <?php if ($user_show): ?>
        <div class="feedback-card__top ">
            <a href="<?= Url::to(['users/view/', 'id' => $user_show['id']]) ?>">
                <?= $user_show['avatar']
                    ? Html::img(Yii::$app->request->baseUrl . $user_show['avatar'], ['width' => '55', 'height' => '55'])
                    : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '55', 'height' => '55']) ?>
            </a>
            <div class="feedback-card__top--name my-list__bottom">
                <p class="link-name"><a href="<?= Url::to(['users/view/', 'id' => $user_show['id']]) ?>"
                                        class="link-regular"><?= $user_show['name'] ?></a></p>
                <a href="#" class="my-list__bottom-chat my-list__bottom-chat--new"><b>3</b></a>
                <?php if ($user_show['rating'] > 0) : ?>
                    <?php $starCount = round($user_show['rating']) ?>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                    <?php endfor; ?>
                    <b><?= round($user_show['rating'], 2) ?></b>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
