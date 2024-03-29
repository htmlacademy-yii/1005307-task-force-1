<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>
    <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => '/tasks/request',
            'fieldConfig' => [
                'errorOptions' => [
                    'tag' => 'span',
                    'style' => 'color: red'
                ]
            ]
        ]
    )
    ?>
    <?= $form->field($model, 'doer_id', [
        'inputOptions' => [
            'value' => $this->params['doer_id'],
            'type' => 'hidden',
        ]
    ])->label(false); ?>
    <?= $form->field($model, 'client_id', [
        'inputOptions' => [
            'value' => $this->params['client_id'],
            'type' => 'hidden',
        ]
    ])->label(false); ?>
    <?= $form->field($model, 'task_id', [
        'inputOptions' => [
            'value' => $this->params['task_id'],
            'type' => 'hidden',
        ]
    ])->label(false); ?>
    <?= $form->field($model, 'completion', [
        'labelOptions' => ['class' => 'completion-label completion-label--yes'],
        'template' => "{input}{error}"
    ])->radioList([1 => 'Да', 2 => 'Возникли проблемы'], [
        'unselect' => null,
        'item' => function ($index, $label, $name, $checked, $value) {
            return '<input class="visually-hidden completion-input '
                . 'completion-input--' . ($value === 1 ? 'yes' : 'difficult') . '" '
                . 'id="completion-radio--' . ($value === 1 ? 'yes' : 'yet') . '" '
                . 'type="radio" name="' . $name . '" value="' . $value . '">'
                . '<label class="completion-label completion-label--'
                . ($value === 1 ? 'yes' : 'difficult') . '" for="' . 'completion-radio--'
                . ($value === 1 ? 'yes' : 'yet') . '">' . $label . '</label>';
        }
    ]) ?>
    <?= $form->field($model, "description", [
        'template' => "<p>{label}\n{input}\n{error}</p>",
        'inputOptions' => [
            'class' => 'input textarea',
            'id' => 'completion-comment',
            'rows' => 4
        ],
        'labelOptions' => [
            'class' => 'form-modal-description',
        ]
    ])->textArea() ?>
    <?= $form->field($model, 'rate', [
        'inputOptions' => [
            'id' => 'rating',
            'type' => 'hidden'
        ],
        'template' => "{input}"
    ]) ?>
    <p class="form-modal-description">
        Оценка
    <div class="feedback-card__top--name completion-form-star">
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
    </div>
    </p>
    <?= Html::submitButton('Отправить',
        ['class' => 'button modal-button']) ?>
    <button class="button modal-button"
            type="button">Отмена
    </button>
    <?php ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
