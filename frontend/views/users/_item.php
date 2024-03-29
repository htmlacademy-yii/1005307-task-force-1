<?php

$formatter = Yii::$app->formatter;

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <a href="<?= Url::to(['users/view', 'id' => $model['id']]) ?>">
                <?= isset($model['avatar'])
                    ? Html::img(Yii::$app->request->baseUrl . strip_tags($model['avatar']), ['width' => '65', 'height' => '65'])
                    : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '65', 'height' => '65']) ?> </a>
            <span>
                <?= isset($model['done_tasks']) ? $model['done_tasks'] : '' ?>
                <?= isset($model['done_tasks']) ? $formatter->getNounPluralForm($model['done_tasks'], 'задание', 'задания', 'заданий') : '' ?>
            </span>
            <span>
                <?= isset($model['opinions_count']) ? $model['opinions_count'] : '' ?>
                <?= isset($model['opinions_count']) ? $formatter->getNounPluralForm($model['opinions_count'], 'отзыв', 'отзыва', 'отзывов') : '' ?>
            </span>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name"><a href="<?= Url::to(['users/view', 'id' => $model['id']]) ?>"
                                    class="link-regular"><?= isset($model['name']) ? strip_tags($model['name']) : '' ?></a>
            </p>
            <?php if (isset($model['rating']) ? $model['rating'] > 0 : ''): ?>
                <?php $starCount = round($model['rating']) ?>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                <?php endfor; ?>
                <b><?= round($model['rating'], 2) ?></b>
            <?php endif; ?>
            <p class="user__search-content">
                <?= isset($model['about']) ? htmlspecialchars($model['about']) : '' ?>
            </p>
        </div>
        <span
            class="new-task__time">Был на сайте <?= isset($model['last_activity_time']) ? $formatter->asRelativeTime($model['last_activity_time'], strftime("%F %T")) : '' ?></span>
    </div>
    <div class="link-specialization user__search-link--bottom">
        <?php if (isset($model['userCategories'])): ?>
            <?php foreach ($model['userCategories'] as $category): ?>
                <a href="<?= Url::to(['tasks/filter', 'category_id' => isset($category['id']) ? $category['id'] : '']) ?>"
                   class="link-regular"><?= isset($category['profession']) ? $category['profession'] : '' ?></a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
