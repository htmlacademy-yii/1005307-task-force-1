<?php /** @noinspection ALL */
$formatter = \Yii::$app->formatter;
$this->title = 'Просмотр задания';
$formatter = \Yii::$app->formatter;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\models\messages\Messages;

$task = $this->params['task'];
$user = $this->params['user'];

?>
<div class="main-container page-container">
    <section class="content-view">
        <div class="content-view__card">
            <div class="content-view__card-wrapper">
                <div class="content-view__header">
                    <div class="content-view__headline">
                        <h1><?= $task->name ?></h1>
                        <span>Размещено в категории
                           <a href="<?= Url::to(['tasks/filter', 'category_id' => $task['category_id']]) ?>"
                              class="link-regular"><?= $task->category->name ?></a>
                           <?= $formatter->asRelativeTime($task->dt_add, strftime("%F %T")) ?>
                           (<?= $task->status_task ?>)
                        </span>
                    </div>
                    <b class="new-task__price new-task__price--<?= $task->category->icon ?> content-view-price">
                        <?= $task->budget ?>
                        <b> ₽</b></b>
                    <div class="new-task__icon new-task__icon--<?= $task->category->icon ?> content-view-icon"></div>
                </div>
                <div class="content-view__description">
                    <h3 class="content-view__h3">Общее описание</h3>
                    <p><?= $task->description ?></p>
                </div>
                <?php $files = $task->fileTasks;
                if ($files): ?>
                    <div class="content-view__attach">
                        <h3 class="content-view__h3">Вложения</h3>
                        <?php foreach ($files as $file): ?>
                            <a href="#"><?= $file->file_item ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if ($task['address']): ?>
                    <div class="content-view__location">
                        <h3 class="content-view__h3">Расположение</h3>
                        <div class="content-view__location-wrapper">
                            <div id="map" style="width: 361px; height: 292px" class="content-view__map"></div>
                            <div class="content-view__address">
                                <span class="address__town"><?= $task->city->city ?></span><br>
                                <span><?= $task->address ?></span>
                                <p><?= $task->location_comment ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php $responses = $task->responses;
        $isUserAuthorOfResponse = false;
        foreach ($task->responses as $response) {
            if ($response->doer_id === $user->id) {
                $isUserAuthorOfResponse = false;
                break;
            }
        }
        $possibleActions = $taskActions->getActionsUser($task['status_task']);
        if ($possibleActions):
            if ($user->user_role == 'doer' || $user->id == $task->client_id) :
                if ($isUserAuthorOfResponse !== true || $task->status_task !== 'Новое'):?>
                    <div class="content-view__action-buttons">
                        <button class=" button button__big-color <?= $possibleActions['title'] ?>-button open-modal"
                                type="button" data-for="<?= $possibleActions['data'] ?>-form">
                            <?= $possibleActions['name'] ?>
                        </button>
                    </div>
                <?php endif;
            endif;
        endif; ?>
        <?php if ($task->status_task == 'Новое' && $task->client_id == $user->id): ?>
            <div class="content-view__action-buttons">
                <a class=" button button__big-color cancel-button open-modal"
                   href="<?= Url::to(['tasks/cancel', 'taskId' => $task->id]) ?>">Отменить</a>
            </div>
        <?php endif; ?>
        <?php if ($response and $user->id === $task->client_id || $isUserAuthorOfResponse && $task->status_task !== 'Провалено'): ?>
            <div class="content-view__feedback">
                <h2>Отклики <span>(<?= count($responses) ?>)</span></h2>
                <div class="content-view__feedback-wrapper">
                    <?php foreach ($responses as $response):
                        if ($response->doer_id === $user->id || $user->id === $task->client_id):
                            $doer = $response->doer; ?>
                            <div class="content-view__feedback-card">
                                <div class="feedback-card__top">
                                    <a href="<?= Url::to(['users/view', 'id' => $doer['id']]) ?>">
                                        <?= $doer->avatar
                                            ? Html::img(Yii::$app->request->baseUrl . $doer->avatar, ['width' => '55', 'height' => '55'])
                                            : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '55', 'height' => '55']) ?>
                                    </a>
                                    <div class="feedback-card__top--name">
                                        <p><a href="<?= Url::to(['users/view', 'id' => $doer->id]) ?>"
                                              class="link-regular"><?= $doer->name ?></a></p>
                                        <?php if ($doer->rating > 0):
                                            $starCount = round($doer['rating']);
                                            for ($i = 1; $i <= 5; $i++):?>
                                                <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                                            <?php endfor; ?>
                                            <b><?= round($doer['rating'], 2) ?></b>
                                        <?php endif; ?>
                                    </div>
                                    <span
                                        class="new-task__time"><?= $formatter->asRelativeTime($task->dt_add, strftime("%F %T")) ?></span>
                                </div>
                                <div class="feedback-card__content">
                                    <p><?= $response->comment ?></p>
                                    <span><?= $response->budget ?> ₽</span>
                                </div>
                                <?php if ($user->id == $task->client_id):
                                    if ($response->is_refused == 0 && $task->status_task == 'Новое'): ?>
                                        <div class="feedback-card__actions">
                                            <a class="button__small-color request-button button" type="button"
                                               href="<?= Url::to(['tasks/start-work', 'taskId' => $task->id, 'doerId' => $response->doer_id]) ?>">Подтвердить</a>
                                            <a class="button__small-color refusal-button button" type="button"
                                               href="<?= Url::to(['tasks/refuse-response', 'responseId' => $response->id]) ?>">Отказать</a>
                                        </div>
                                    <?php endif;
                                endif; ?>
                            </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <?php $isClientNotNewTask = false;
    if ($task->status_task !== 'Новое' && $task->status_task !== 'Отменено' && $user->id == $task->client_id) {
        $isClientNotNewTask = true;
    } ?>
    <?php $isClientNotNewTask
        ? $user_show = $task->doer
        : $user_show = $task->client;
    $doer = $task->doer;
    ?>
    <?php if ($task->status_task == 'Новое' && $user->id == $task->client->id) {
        $user_show = null;
    } ?>
    <?php if($user_show): ?>
        <section class="connect-desk">
            <div class="connect-desk__profile-mini">
                <div class="profile-mini__wrapper">
                    <h3><?= $isClientNotNewTask ? 'Исполнитель' : 'Заказчик' ?></h3>
                    <div class="profile-mini__top">
                        <?= $user_show->avatar
                            ? Html::img(Yii::$app->request->baseUrl . $user_show->avatar, ['alt' => 'Аватар заказчика', 'width' => '62', 'height' => '62'])
                            : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['alt' => 'Аватар заказчика', 'width' => '62', 'height' => '62']) ?>
                        <div class="profile-mini__name five-stars__rate">
                            <p><?= $user_show->name ?></p>
                            <?php if ($user_show['rating'] !== 0 && $isClientNotNewTask): ?>
                                <div class="profile-mini__name five-stars__rate">
                                    <?php $starCount = round($user_show['rating']) ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                                    <?php endfor; ?>
                                    <b><?= round($user_show['rating'], 2) ?></b>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="info-customer">
                        <?php if ($isClientNotNewTask): ?>
                            <span>Выполнено <?= $user_show->done_tasks ?> <?= $formatter->getNounPluralForm($user_show->done_tasks, 'задание', 'задания', 'заданий') ?></span>
                            <span>Провалено <?= $user_show->failed_tasks ?> <?= $formatter->getNounPluralForm($user_show->failed_tasks, 'задание', 'задания', 'заданий') ?></span>
                            <span class="last-"><?= $formatter->getPeriodTime($user_show->dt_add) ?></span>
                        <?php endif; ?>
                        <?php if (!$isClientNotNewTask): ?>
                            <span>Создано <?= $user_show->created_tasks ?> <?= $formatter->getNounPluralForm($user_show->created_tasks, 'задание', 'задания', 'заданий') ?></span>
                            <span class="last-"><?= $formatter->getPeriodTime($user_show->dt_add) ?></span>
                        <?php endif; ?>
                    </p>
                    <a href="<?= Url::to(['users/view', 'id' => $user_show->id]) ?>" class="link-regular">
                        Смотреть профиль
                    </a>
                </div>
            </div>
            <?php if ($task->doer_id && $user->id == $task->doer_id || $user->id == $task->client_id):
                if ($task->status_task !== 'Новое' && $task->status_task !== 'Отмененное'): ?>
                    <div id="chat-container">
                        <chat class="connect-desk__chat" task="<?= $task->id ?>"></chat>
                    </div>
                <?php endif;
            endif; ?>
        </section>
    <?php endif; ?>
</div>
