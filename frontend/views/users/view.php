<?php
$formatter = Yii::$app->formatter;
$this->title = 'Исполнитель ' . $user['name'];

use yii\helpers\Html;
use yii\helpers\Url;

$user_account = $this->params['user'];

?>

<div class="main-container page-container">
    <section class="content-view">
        <div class="user__card-wrapper">
            <div class="user__card">
                <?= $user['avatar']
                    ? Html::img(Yii::$app->request->baseUrl . '/img/' . $user['avatar'], ['alt' => 'Аватар пользователя', 'width' => '120', 'height' => '120'])
                    : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '120', 'height' => '120']) ?>
                <div class="content-view__headline">
                    <?php
                    $isClient = false;
                    if ($user['user_role'] == 'client') {
                        $isClient = true;
                    }
                    ?>
                    <h1><?= $user['name'] ?></h1>
                    <p>Россия, <?= $user['city']['city'] ?>,
                        <?= $user['bd'] ? $formatter->getAge($user['bd']) : "" ?>
                        <?= $user['bd'] ? $formatter->getNounPluralForm($formatter->getAge($user['bd']), 'год', 'года', 'лет') : "" ?>
                    </p>
                    <?php if ($user['rating'] > 0): ?>
                        <div class="profile-mini__name five-stars__rate">
                            <?php $starCount = round($user['rating']) ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                            <?php endfor; ?>
                            <b><?= round($user['rating'], 2) ?></b>
                        </div>
                    <?php endif; ?>
                    <?php if ($isClient !== true):
                        if ($user['done_tasks'] !== 0):?>
                            <b class="done-task"><?= 'Выполнил' ?> <?= $user['done_tasks'] ?> <?= $formatter->getNounPluralForm($user['done_tasks'], 'заказ', 'заказа', 'заказов') ?></b>
                            <b class="done-review">Получил <?= $user['opinions_count'] ?> <?= $formatter->getNounPluralForm($user['opinions_count'], 'отзыв', 'отзыва', 'отзывов') ?></b>
                        <?php endif;
                    endif; ?>
                    <?php if ($isClient == true):
                        if ($user['created_tasks'] !== 0):?>
                            <b class="done-task"><?= 'Создал' ?> <?= $user['created_tasks'] ?> <?= $formatter->getNounPluralForm($user['created_tasks'], 'заказ', 'заказа', 'заказов') ?></b>
                        <?php endif;
                    endif; ?>
                    <?php $favourites = $user['favourites'];
                    $isFavourite = false;
                    foreach ($favourites as $favourite) {
                        if ($favourite['user_id'] === $user_account['id']) {
                            $isFavourite = true;
                            break;
                        }
                    } ?>
                </div>
                <div
                    class="content-view__headline user__card-bookmark <?= $isFavourite ? 'user__card-bookmark--current' : '' ?>">
                    <span>Был на сайте <?= $formatter->asRelativeTime($user['last_activity_time'], strftime("%F %T")) ?></span>
                    <?php if ($user->id != $user_account->id) : ?>
                        <a href="<?= Url::to(['users/add-favourite', 'isFavouriteValue' => $isFavourite, 'id' => $user['id']]) ?>"><b></b></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="content-view__description">
                <p><?= $user['about'] ?></p>
            </div>
            <div class="user__card-general-information">
                <div class="user__card-info">
                    <?php $categories = $user['userCategories'] ?>
                    <?php if ($categories) : ?>
                        <h3 class="content-view__h3">Специализации</h3>
                        <div class="link-specialization">
                            <?php foreach ($categories as $category) : ?>
                                <a href="<?= Url::to(['tasks/filter',
                                    'category_id' => $category['id']]) ?>"
                                   class="link-regular"><?= $category['profession'] ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="content-view__h3">Контакты</h3>
                    <div class="user__card-link">
                        <a class="user__card-link--tel link-regular"
                           href="tel:<?= $user['phone'] ?>"><?= $user['phone'] ?></a>
                        <?= $formatter->asEmail($user['email'], ['class' => 'user__card-link--email link-regular']) ?>
                        <?php if ($user['skype']) : ?>
                            <a class="user__card-link--skype link-regular"
                               href="skype:<?= $user['skype'] ?>"><?= $user['skype'] ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php $portfolio = $user['portfolioPhotos'];
                if ($portfolio): ?>
                    <div class="user__card-photo">
                        <h3 class="content-view__h3">Фото работ</h3>
                        <?php foreach ($portfolio as $portfolio_photo) : ?>
                            <a>
                                <img src='/img/<?=$portfolio_photo["photo"]?>' alt='Фото' width='85' height='86' onclick = 'openImageWindow(this.src);' />
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php $opinions = $user['opinions'];
        if ($opinions): ?>
            <div class="content-view__feedback">
                <h2>Отзывы<span>(<?= count($opinions) ?>)</span></h2>
                <div class="content-view__feedback-wrapper reviews-wrapper">
                    <?php foreach ($opinions as $opinion) : ?>
                        <?php $task = $opinion['task'] ?>
                        <?php $writer = $opinion['client'] ?>
                        <div class="feedback-card__reviews">
                            <p class="link-task link">Задание
                                <a href="<?= Url::to(['tasks/view', 'id' => $task['id']]) ?>"
                                   class="link-regular">«<?= $task['name'] ?>»</a>
                            </p>
                            <div class="card__review">
                                <a href="<?= Url::to(['users/view', 'id' => $writer['id']]) ?>">
                                    <?= $writer->avatar
                                        ? Html::img(Yii::$app->request->baseUrl . '/img/' . $writer->avatar, ['alt' => 'Аватар заказчика', 'width' => '62', 'height' => '62'])
                                        : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['alt' => 'Аватар заказчика', 'width' => '62', 'height' => '62']) ?></a>
                                <div class="feedback-card__reviews-content">
                                    <p class="link-name link">
                                        <a href="<?= Url::to(['users/view', 'id' => $writer['id']]) ?>"><?= $writer['name'] ?></a>
                                    </p>
                                    <p class="review-text"><?= $opinion['description'] ?></p>
                                </div>
                                <?php if ($opinion['rate']): ?>
                                    <div class="card__review-rate">
                                        <p class="<?= $formatter->getRatingType($opinion['rate']) ?>-rate big-rate"><?= $opinion['rate'] ?>
                                            <span></span></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__chat">

        </div>
    </section>
</div>

