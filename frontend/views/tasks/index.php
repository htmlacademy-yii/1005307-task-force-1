<?php
$this->title = 'Список заданий';
$formatter = \Yii::$app->formatter;

use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$categoriesFilter = $searchForm->getCategoriesFilter();
$periodFilter = $searchForm->getPeriodFilter();
?>
<div class="main-container page-container">
    <section class="new-task">
        <div class="new-task__wrapper">
            <h1>Новые задания</h1>
            <?php foreach ($tasks as $task): ?>
                <div class="new-task__card">
                    <div class="new-task__title">
                        <a href="<?= Url::to(['tasks/view/', 'id' => $task['id']]) ?>" class="link-regular">
                            <h2><?= $task['name'] ?></h2></a>
                        <a class="new-task__type link-regular" href="#"><p><?= $task['category']['name'] ?></p></a>
                    </div>
                    <div class="new-task__icon new-task__icon--<?= $task['category']['icon'] ?>"></div>
                    <p class="new-task_description">
                        <?= $task['description'] ?>
                    </p>
                    <b class="new-task__price new-task__price--<?= $task['category']['icon'] ?>">
                        <?= $task['budget'] ?> <b> ₽</b></b>
                    <p class="new-task__place"><?= $task['city'] ? ($task['city']['city']) : 'Удаленная работа' ?> <?= $task['address'] ?></p>
                    <span class="new-task__time"><?= $formatter->asRelativeTime($task['dt_add']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="new-task__pagination">
            <?= LinkPager::widget([
                'pagination' => $page,
                'options' => ([
                    'class' => 'new-task__pagination-list',
                ]),
                'activePageCssClass' => 'pagination__item pagination__item--current',
                'pageCssClass' => 'pagination__item',
                'prevPageCssClass' => 'pagination__item',
                'nextPageCssClass' => 'pagination__item',
                'prevPageLabel' => '',
                'nextPageLabel' => '',
                'linkOptions' => ([
                    'style' => 'padding-top: 40%; height: 100%; width: 100%; text-align: center; vertical-align: middle'
                ])
            ]); ?>
        </div>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">
            <?php $form = ActiveForm::begin([
                'id' => 'searchForm',
                'method' => 'post',
                'options' => [
                    'name' => 'test',
                    'class' => 'search-task__form'
                ]
            ]); ?>
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <?php $i = 1; ?>
                <?php foreach ($categoriesFilter as $id => $name) : ?>
                    <?= $form->field($searchForm, 'searchedCategories[]', [
                        'template' => '{input}',
                        'options' => ['tag' => false]
                    ])->checkbox([
                        'label' => false,
                        'value' => $id,
                        'uncheck' => null,
                        'checked' => in_array($id, $searchForm->searchedCategories),
                        'id' => $id,
                        'class' => 'visually-hidden checkbox__input'
                    ]) ?>
                    <?php $i++; ?>
                    <label for="<?= $id ?>"><?= $name ?></label>
                <?php endforeach; ?>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?= $form->field($searchForm, 'noReplies', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'noReplies',
                    'uncheck' => null,
                    'id' => 'noReplies',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="noReplies">Без откликов</label>
                <?= $form->field($searchForm, 'online', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'online',
                    'uncheck' => null,
                    'id' => 'online',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="online">Удаленная работа</label>
            </fieldset>
            <label class="search-task__name" for="<?= $i ?>">Период</label>
            <?= $form->field($searchForm, "periodFilter", [
                'template' => "{input}",
                'options' => ['tag' => false]
            ])->dropDownList($periodFilter, [
                'class' => 'multiple-select input',
                'id' => ($i),
                'size' => 1,
                'prompt' => [
                    'text' => 'За всё вреня',
                    'options' => ['value' => 'all']
                ]
            ]); ?>
            <?php $i++; ?>
            <label class="search-task__name" for="<?= $i ?>">Поиск по названию</label>
            <?= $form->field($searchForm, 'searchName', [
                'template' => "{input}",
                'options' => ['tag' => false],
                'inputOptions' => [
                    'class' => 'input-middle input',
                    'type' => 'search',
                    'id' => $i
                ]
            ]); ?>
            <?= Html::submitButton('Искать',
                ['class' => 'button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </section>
</div>
