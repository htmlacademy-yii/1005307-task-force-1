<div class="feedback-card__top">
    <div class="user__search-icon">
        <a href="#"><img src="../img/<?= $user['avatar'] ?>" width="65" height="65"
                         alt="<?= $user['name'] ?>"></a>
        <span><?= $user['finished_task_count'] ?> <?= get_noun_plural_form($user['finished_task_count'], 'задание', 'задания', 'заданий') ?></span>
        <span><?= $user['opinions_count'] ?> <?= get_noun_plural_form($user['opinions_count'], 'отзыв', 'отзыва', 'отзывов') ?></span>
    </div>
    <div class="feedback-card__top--name user__search-card">
        <p class="link-name"><a href="#" class="link-regular"><?= $user['name'] ?></a></p>
        <?php $starCount = round((float)$user['rating']) ?>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
        <?php endfor; ?>
        <b><?= floor($user['rating'] * 100) / 100 ?></b>
        <p class="user__search-content">
            <?= $user['about'] ?>
        </p>
    </div>
    <span
        class="new-task__time">Был на сайте <?= getPassedTimeSinceLastActivity($user['last_activity_time']) ?></span>
</div>
