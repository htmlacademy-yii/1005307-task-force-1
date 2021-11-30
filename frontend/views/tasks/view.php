<?php

use frontend\models\responses\Responses;
use frontend\models\tasks\Tasks;
use yii\helpers\Html;
use yii\helpers\Url;

$formatter = \Yii::$app->formatter;
$this->title = 'Просмотр задания';

$task = $this->params['task'];
$user = $this->params['user'];

if (isset($task->fileTasks)) {
    $files = $task->fileTasks;
}

$responses = null;

$possibleActions = null;
$isClient = false;
$doerWithoutResponse = false;
$doerWithResponse = false;
$isDoer = false;
$user_show = null;
$show_rating = false;
$chat = false;
$possibleActionsWithResponses = false;

$taskActions = new Tasks();

if ($user->id === $task->client_id) {
    $isClient = true;
    $responses = $task->responses;
    $chat = true;
    $possibleActions = $taskActions->nextAction($task['status_task'], 'client');

    if ($task->status_task === 'Новое') {
        $user_show = null;
        $possibleActionsWithResponses = true;
        $possibleActions = $taskActions->nextAction($task['status_task'], 'client');
    }

    $user_show = $task->doer;
}

$response = new Responses();
$user_response = $response->getUserResponse($user->id, $task->id);

if (!$user_response && !$isClient) {
    $doerWithoutResponse = true;
    $user_show = $task->client;
    $responses = null;
    $possibleActions = $taskActions->nextAction($task['status_task'], 'doer');

    if ($user->user_role === 'client') {
        $possibleActions = null;
    }
}

if ($user_response && !$isClient) {
    $doerWithResponse = true;
    $responses = $user_response;
    $user_show = $task->client;

    if ($task->status_task === 'Новое') {
        $possibleActions = null;
    }
}

if ($task->status_task !== 'Новое' && !$isClient) {
    $idDoer = true;
    $chat = true;
    $possibleActions = $taskActions->nextAction($task['status_task'], 'doer');
}

if ($user_show->rating > 0) {
    $show_rating = true;
}

?>

<div class="main-container page-container">
    <section class="content-view">
        <div class="content-view__card">
            <div class="content-view__card-wrapper">
                <div class="content-view__header">
                    <div class="content-view__headline">
                        <h1><?= isset($task->name) ? strip_tags($task->name) : '' ?></h1>
                        <span>Размещено в категории
                           <a href="<?= isset($task->category_id) ? Url::to(['tasks/filter', 'category_id' => $task->category_id]) : '' ?>"
                              class="link-regular"><?= isset($task->category->name) ? $task->category->name : '' ?></a>
                           <?= isset($task->dt_add) ? $formatter->asRelativeTime($task->dt_add, strftime("%F %T")) : '' ?>
                           (<?= isset($task->status_task) ? $task->status_task : ''?>)
                        </span>
                    </div>
                    <b class="new-task__price new-task__price--<?= isset($task->category->icon) ? $task->category->icon : '' ?> content-view-price">
                        <?= strip_tags($task->budget) ?>
                        <b> ₽</b></b>
                    <div class="new-task__icon new-task__icon--<?= isset($task->category->icon) ? $task->category->icon : '' ?> content-view-icon"></div>
                </div>
                <div class="content-view__description">
                    <h3 class="content-view__h3">Общее описание</h3>
                    <p><?= isset($task->description) ? htmlspecialchars($task->description) : '' ?></p>
                </div>
                <?php if ($files): ?>
                    <div class="content-view__attach">
                        <h3 class="content-view__h3">Вложения</h3>
                        <?php foreach ($files as $file): ?>
                            <a href="#"><?= isset($file->file_item) ? strip_tags($file->file_item) : '' ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if ($task->address): ?>
                    <div class="content-view__location">
                        <h3 class="content-view__h3">Расположение</h3>
                        <div class="content-view__location-wrapper">
                            <div id="map" style="width: 361px; height: 292px" class="content-view__map"></div>
                            <div class="content-view__address">
                                <span class="address__town"><?= isset($task->city->city) ? $task->city->city : '' ?></span><br>
                                <span><?= isset($task->address) ? strip_tags($task->address) : '' ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($possibleActions): ?>
            <div class="content-view__action-buttons">
                <button class=" button button__big-color <?= isset($possibleActions['title']) ? $possibleActions['title'] : '' ?>-button open-modal"
                        type="button" data-for="<?= isset($possibleActions['data']) ? $possibleActions['data'] : '' ?>-form">
                    <?= isset($possibleActions['name']) ? $possibleActions['name'] : '' ?>
                </button>
            </div>
        <?php endif; ?>
        <?php if ($isClient && $task->status_task === 'Новое'): ?>
            <div class="content-view__action-buttons">
                <a class=" button button__big-color cancel-button open-modal"
                   href="<?= Url::to(['tasks/cancel', 'taskId' => $task->id]) ?>">Отменить</a>
            </div>
        <?php endif; ?>
        <?php if ($responses): ?>
            <div class="content-view__feedback">
                <h2>Отклики <span>(<?= isset($task['responses_count']) ? $task['responses_count'] : '' ?>)</span></h2>
                <div class="content-view__feedback-wrapper">
                    <?php foreach ($responses as $response):
                        $doer = $response->doer; ?>
                        <div class="content-view__feedback-card">
                            <div class="feedback-card__top">
                                <a href="<?= Url::to(['users/view', 'id' => $doer['id']]) ?>">
                                    <?= isset($doer->avatar)
                                        ? Html::img(Yii::$app->request->baseUrl . strip_tags($doer->avatar), ['width' => '55', 'height' => '55'])
                                        : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '55', 'height' => '55']) ?>
                                </a>
                                <div class="feedback-card__top--name">
                                    <p><a href="<?= Url::to(['users/view', 'id' => $doer->id]) ?>"
                                          class="link-regular"><?= isset($doer->name) ? strip_tags($doer->name) : '' ?></a></p>
                                    <?php if (isset($doer->rating) ? $doer->rating > 0 : ''):
                                        $starCount = round($doer['rating']);
                                        for ($i = 1; $i <= 5; $i++):?>
                                            <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                                        <?php endfor; ?>
                                        <b><?= round($doer['rating'], 2) ?></b>
                                    <?php endif; ?>
                                </div>
                                <span
                                    class="new-task__time"><?= isset($task->dt_add) ? $formatter->asRelativeTime($task->dt_add, strftime("%F %T")) : '' ?></span>
                            </div>
                            <div class="feedback-card__content">
                                <p><?= isset($response->comment) ? htmlspecialchars($response->comment) : '' ?></p>
                                <span><?= isset($response->budget) ? strip_tags($response->budget) : '' ?> ₽</span>
                            </div>
                            <?php if ($possibleActionsWithResponses && $response->is_refused === 0): ?>
                                <div class="feedback-card__actions">
                                    <a class="button__small-color request-button button" type="button"
                                       href="<?= Url::to(['tasks/start-work', 'taskId' => $task->id, 'doerId' => $response->doer_id]) ?>">Подтвердить</a>
                                    <a class="button__small-color refusal-button button" type="button"
                                       href="<?= Url::to(['tasks/refuse-response', 'responseId' => $response->id]) ?>">Отказать</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <?php if ($user_show): ?>
        <section class="connect-desk">
            <div class="connect-desk__profile-mini">
                <div class="profile-mini__wrapper">
                    <h3><?= $isClient ? 'Исполнитель' : 'Заказчик' ?></h3>
                    <div class="profile-mini__top">
                        <?= isset($user_show->avatar)
                            ? Html::img(Yii::$app->request->baseUrl . strip_tags($user_show->avatar), ['alt' => 'Аватар заказчика', 'width' => '62', 'height' => '62'])
                            : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['alt' => 'Аватар заказчика', 'width' => '62', 'height' => '62']) ?>
                        <div class="profile-mini__name five-stars__rate">
                            <p><?= isset($user_show->name) ? strip_tags($user_show->name) : ''?></p>
                            <?php if ($show_rating): ?>
                                <div class="profile-mini__name five-stars__rate">
                                    <?php $starCount = isset($user_show->rating) ? round($user_show->rating) : '' ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                                    <?php endfor; ?>
                                    <b><?= isset($user_show->rating) ? round($user_show->rating, 2) : '' ?></b>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="info-customer">
                        <?php if ($isClient && isset($user_show->done_tasks, $user_show->failed_tasks)): ?>
                            <span>Выполнено <?= $user_show->done_tasks ?> <?= $formatter->getNounPluralForm($user_show->done_tasks, 'задание', 'задания', 'заданий') ?></span>
                            <span>Провалено <?= $user_show->failed_tasks ?> <?= $formatter->getNounPluralForm($user_show->failed_tasks, 'задание', 'задания', 'заданий') ?></span>
                            <span class="last-"><?= $formatter->getPeriodTime($user_show->dt_add) ?></span>
                        <?php endif; ?>
                        <?php if (!$isClient && isset($user_show->created_tasks)): ?>
                            <span>Создано <?= $user_show->created_tasks ?> <?= $formatter->getNounPluralForm($user_show->created_tasks, 'задание', 'задания', 'заданий') ?></span>
                            <span class="last-"><?= isset($user_show->dt_add) ? $formatter->getPeriodTime($user_show->dt_add) : '' ?></span>
                        <?php endif; ?>
                    </p>
                    <a href="<?= Url::to(['users/view', 'id' => $user_show->id]) ?>" class="link-regular">
                        Смотреть профиль
                    </a>
                </div>
            </div>
            <?php if ($chat): ?>
                <div id="chat-container">
                    <chat class="connect-desk__chat" task="<?= $task->id ?>"></chat>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</div>
