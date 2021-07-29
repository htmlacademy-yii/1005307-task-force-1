<?php /** @noinspection ALL */
$formatter = \Yii::$app->formatter;
$this->title = 'Задание ' . $task['name'];

use yii\helpers\Html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>
<div class="main-container page-container">
    <section class="content-view">
        <div class="content-view__card">
            <div class="content-view__card-wrapper">
                <div class="content-view__header">
                    <div class="content-view__headline">
                        <h1><?= $task['name'] ?></h1>
                        <span>Размещено в категории
                           <a href="#" class="link-regular"><?= $task['category']['name'] ?></a>
                           <?= $formatter->asRelativeTime($task['dt_add'], strftime("%F %T")) ?>
                        </span>
                    </div>
                    <b class="new-task__price new-task__price--<?= $task['category']['icon'] ?> content-view-price"><?= $task['budget'] ?>
                        <b> ₽</b></b>
                    <div
                        class="new-task__icon new-task__icon--<?= $task['category']['icon'] ?> content-view-icon"></div>
                </div>
                <div class="content-view__description">
                    <h3 class="content-view__h3">Общее описание</h3>
                    <p>
                        <?= $task['description'] ?>
                    </p>
                </div>
                <?php $files = $task['fileTasks'] ?>
                <?php if ($files): ?>
                    <div class="content-view__attach">
                        <h3 class="content-view__h3">Вложения</h3>
                        <?php foreach ($files as $file) : ?>
                            <a href="#"> <?= $file['file_item'] ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if ($task['city']): ?>
                    <div class="content-view__location">
                        <h3 class="content-view__h3">Расположение</h3>
                        <div class="content-view__location-wrapper">
                            <div class="content-view__map">
                                <a href="#">
                                    <img src="/img/map.jpg" width="361" height="292"
                                         alt="<?= $task['city']['city'] ?>, <?= $task['address'] ?>"></a>
                            </div>
                            <div class="content-view__address">
                                <span class="address__town"><?= $task['city']['city'] ?></span><br>
                                <span><?= $task['address'] ?></span>
                                <p><?= $task['location_comment'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php $possibleActions = $taskActions->getActionsUser($task['status_task']) ?>
            <?php if ($possibleActions): ?>
                <div class="content-view__action-buttons">
                    <button class=" button button__big-color <?= $possibleActions['title'] ?>-button open-modal"
                            type="button"
                            data-for="<?= $possibleActions['data'] ?>-form"><?= $possibleActions['name'] ?>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <?php $responses = $task['responses'] ?>
        <?php if ($responses): ?>
            <?php if ($user['id'] == $task['client_id']): ?>
                <div class="content-view__feedback">
                    <h2>Отклики <span>(<?= count($responses) ?>)</span></h2>
                    <div class="content-view__feedback-wrapper">
                        <?php foreach ($responses as $response) : ?>
                            <?php $doer = $response['doer'];
                            $opinions = $doer['opinions'];
                            $rating = 0;

                            if (!empty($opinions)) {
                                $ratesCount = 0;
                                $ratesSum = 0;

                                foreach ($opinions as $opinion) {
                                    $ratesCount++;
                                    $ratesSum += $opinion['rate'];
                                }

                                $rating = round(($ratesSum / $ratesCount), 2);
                            } ?>
                            <div class="content-view__feedback-card">
                                <div class="feedback-card__top">
                                    <a href="<?= Url::to(['users/view', 'id' => $doer['id']]) ?>">
                                        <?= $doer['avatar'] ? Html::img(Yii::$app->request->baseUrl . '/img/' . $doer['avatar'], ['width' => '55', 'height' => '55']) : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '55', 'height' => '55']) ?>
                                    </a>
                                    <div class="feedback-card__top--name">
                                        <p><a href="<?= Url::to(['users/view', 'id' => $doer['id']]) ?>"
                                              class="link-regular"><?= $doer['name'] ?></a></p>
                                        <?php if ($rating > 0) : ?>
                                            <?php $starCount = round($rating) ?>
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                                            <?php endfor; ?>
                                            <b><?= $rating ?></b>
                                        <?php endif; ?>
                                    </div>
                                    <span
                                        class="new-task__time"><?= $formatter->asRelativeTime($task['dt_add'], strftime("%F %T")) ?></span>
                                </div>
                                <div class="feedback-card__content">
                                    <p>
                                        <?= $response['comment'] ?>
                                    </p>
                                    <span><?= $response['budget'] ?> ₽</span>
                                </div>
                                <?php if ($user['id'] == $task['client_id']): ?>
                                    <div class="feedback-card__actions">
                                        <a class="button__small-color request-button button"
                                           type="button">Подтвердить</a>
                                        <a class="button__small-color refusal-button button"
                                           type="button">Отказать</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="content-view__feedback">
            <?php foreach ($responses as $response) : ?>
                <?php if ($response['doer_id'] == $user['id']): ?>
                    <div class="content-view__feedback-wrapper">
                        <h2>Отклики <span>(<?= count($responses) ?>)</span></h2>
                        <?php $doer = $response['doer'];
                        $opinions = $doer['opinions'];
                        $rating = 0;

                        if (!empty($opinions)) {
                            $ratesCount = 0;
                            $ratesSum = 0;

                            foreach ($opinions as $opinion) {
                                $ratesCount++;
                                $ratesSum += $opinion['rate'];
                            }

                            $rating = round(($ratesSum / $ratesCount), 2);
                        } ?>
                        <div class="content-view__feedback-card">
                            <div class="feedback-card__top">
                                <a href="<?= Url::to(['users/view', 'id' => $doer['id']]) ?>">
                                    <?= $doer['avatar'] ? Html::img(Yii::$app->request->baseUrl . '/img/' . $doer['avatar'], ['width' => '55', 'height' => '55']) : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '55', 'height' => '55']) ?>
                                </a>
                                <div class="feedback-card__top--name">
                                    <p><a href="<?= Url::to(['users/view', 'id' => $doer['id']]) ?>"
                                          class="link-regular"><?= $doer['name'] ?></a></p>
                                    <?php if ($rating > 0) : ?>
                                        <?php $starCount = round($rating) ?>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                                        <?php endfor; ?>
                                        <b><?= $rating ?></b>
                                    <?php endif; ?>
                                </div>
                                <span
                                    class="new-task__time"><?= $formatter->asRelativeTime($task['dt_add'], strftime("%F %T")) ?></span>
                            </div>
                            <div class="feedback-card__content">
                                <p>
                                    <?= $response['comment'] ?>
                                </p>
                                <span><?= $response['budget'] ?> ₽</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__profile-mini">
            <div class="profile-mini__wrapper">
                <h3>Заказчик</h3>
                <?php $client = $task['client'] ?>
                <?php $tasks = $client['tasks'] ?>
                <div class="profile-mini__top">
                    <?= $client['avatar'] ? Html::img(Yii::$app->request->baseUrl . '/img/' . $client['avatar'], ['alt' => 'Аватар заказчика', 'width' => '62', 'height' => '62']) : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['alt' => 'Аватар заказчика', 'width' => '62', 'height' => '62']) ?>
                    <div class="profile-mini__name five-stars__rate">
                        <p><?= $client['name'] ?></p>
                    </div>
                </div>
                <p class="info-customer">
                    <span><?= count($tasks) ?> <?= $formatter->getNounPluralForm(count($tasks), 'задание', 'задания', 'заданий') ?></span>
                    <span class="last-"><?= $formatter->getPeriodTime($client['dt_add']) ?></span>
                </p>
                <a href="<?= Url::to(['users/view', 'id' => $client['id']]) ?>" class="link-regular">Смотреть
                    профиль</a>
            </div>
        </div>
        <div id="chat-container">
            <!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
            <chat class="connect-desk__chat"></chat>
        </div>
    </section>
</div>
<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'validationStateOn' => 'input',
        'action' => '/tasks/response',
        'options' => ['style' => 'margin-top: 12px; margin-bottom: 8px;'],
        //  'validateOnBlur' => true,
        //  'validateOnChange' => true,
        //  'validateOnSubmit' => true,
        'fieldConfig' => [
            'inputOptions' => [
                'class' => 'form-modal-description',
                'style' => 'margin-top: 12px; margin-bottom: 8px;',
            ],
            'errorOptions' => ['tag' => 'span', 'style' => 'color: red'],
            'labelOptions' => [
                'class' => 'form-modal-description',
            ],
        ]]) ?>
    <?= $form->field($responseForm, 'doer_id', [
        'options' => ['style' => 'margin-top: 0'],
        'inputOptions' => [
            'class' => 'input textarea',
            'value' => $user['id'],
            'type' => 'hidden',
            'style' => 'margin-bottom: 0'
        ]
    ])->label(false); ?>
    <?= $form->field($responseForm, 'task_id', [
        'options' => ['style' => 'margin-top: 0'],
        'inputOptions' => [
            'class' => 'input textarea',
            'value' => $task['id'],
            'type' => 'hidden',
            'style' => 'margin-bottom: 0'
        ]
    ])->label(false); ?>
    <?= $form->field($responseForm, "budget", [
        'template' => "<p>{label}\n{input}\n{error}</p>",
        'inputOptions' => [
            'class' => 'response-form-payment input input-middle input-money',
            'id' => 'response-payment',
        ]
    ])->input('number') ?>
    <?= $form->field($responseForm, "comment", [
        'template' => "<p>{label}\n{input}\n{error}</p>",
        'inputOptions' => [
            'class' => 'input textarea',
            'id' => 'response-comment',
            'rows' => 4
        ]
    ])->textArea() ?>
    <button class="button modal-button" type="submit">Отправить</button>
    <?php ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
