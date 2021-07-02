<?php
$this->title = 'Список заданий';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

$categoriesFilter = $searchForm->getCategoriesFilter();
$periodFilter = $searchForm->getPeriodFilter();
?>
<div class="main-container page-container">
    <section class="new-task">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'layout' => "<div class='new-task__wrapper'>
                <h1>Новые задания</h1>
                {items}
            </div>\n
            <div class='new-task__pagination'>{pager}</div>",
            'emptyText' => 'Исполнителей пока нет',
            'emptyTextOptions' => [
                'tag' => 'p'
            ],
            'itemOptions' => [
                'style' => 'border-bottom: 2px solid #d4d4d4',
            ],
            'pager' => [
                'options' => ([
                    'class' => 'new-task__pagination-list',
                    'style' => 'width: 100%'
                ]),
                'pageCssClass' => 'pagination__item',
                'prevPageCssClass' => 'pagination__item',
                'nextPageCssClass' => 'pagination__item',
                'nextPageLabel' => '',
                'prevPageLabel' => '',
                'maxButtonCount' => 5,
                'activePageCssClass' => 'pagination__item pagination__item--current',
                'linkOptions' => ([
                    'style' => 'padding-top: 45%; height: 100%; width: 100%; text-align: center'
                ])
            ],
        ])
        ?>
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
