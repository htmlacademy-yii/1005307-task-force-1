<?php
$this->title = 'Список исполнителей';
$formatter = \Yii::$app->formatter;

use frontend\models\categories\Categories;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$additionalFilter = $searchForm->attributeLabels();
$categoriesFilter = Categories::getCategories();
?>

<div class="main-container page-container">
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'itemOptions' => [
            'tag' => false,
        ],
        'layout' => '<section class="user__search"><div class="user__wrapper">{items}</div></section>
            <div class="new-task__pagination" style="margin-right: 20px">{pager}</div>',
        'emptyText' => '<section class="user__search"><div class="user__wrapper">Исполнителей пока нет</div></section>',
        'emptyTextOptions' => ['tag' => 'p'],
        'pager' => [
            'options' => (['class' => 'new-task__pagination-list',]),
            'pageCssClass' => 'pagination__item',
            'prevPageCssClass' => 'pagination__item',
            'nextPageCssClass' => 'pagination__item',
            'nextPageLabel' => '',
            'prevPageLabel' => '',
            'maxButtonCount' => 5,
            'activePageCssClass' => 'pagination__item pagination__item--current',

        ],
    ])
    ?>
    <section class="search-task">
        <div class="search-task__wrapper">
            <?php $form = ActiveForm::begin([
                'id' => 'searchForm',
                'method' => 'get',
                'options' => [
                    'name' => 'test',
                    'class' => 'search-task__form'
                ],
                'action' => '/users/'
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
                <?= $form->field($searchForm, 'isFreeNow', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'isFreeNow',
                    'uncheck' => null,
                    'id' => 'isFreeNow',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="isFreeNow">Сейчас свободен</label>
                <?= $form->field($searchForm, 'isOnlineNow', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'isOnlineNow',
                    'uncheck' => null,
                    'id' => 'isOnlineNow',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="isOnlineNow">Сейчас онлайн</label>
                <?= $form->field($searchForm, 'hasOpinions', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'hasOpinions',
                    'uncheck' => null,
                    'id' => 'hasOpinions',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="hasOpinions">С отзывами</label>
                <?= $form->field($searchForm, 'isFavourite', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'isFavourite',
                    'uncheck' => null,
                    'id' => 'isFavourite',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="isFavourite">В избранном</label>
            </fieldset>
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
