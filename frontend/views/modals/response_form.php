<?php
use yii\widgets\ActiveForm;
?>

<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'validationStateOn' => 'input',
        'action' => '/tasks/response',
        'options' => ['style' => 'margin-top: 12px; margin-bottom: 8px;'],
        'validateOnBlur' => true,
        'validateOnChange' => true,
        'validateOnSubmit' => true,
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
    <?= $form->field($model, 'doer_id', [
        'options' => ['style' => 'margin-top: 0'],
        'inputOptions' => [
            'value' => $this->params['user_id'],
            'type' => 'hidden',
        ]
    ])->label(false); ?>
    <?= $form->field($model, 'task_id', [
        'inputOptions' => [
            'value' => $this->params['task_id'],
            'type' => 'hidden',
        ]
    ])->label(false); ?>
    <?= $form->field($model, 'is_refused', [
        'inputOptions' => [
            'value' => '0',
            'type' => 'hidden',
        ]
    ])->label(false); ?>
    <?= $form->field($model, "budget", [
        'template' => "<p>{label}\n{input}\n{error}</p>",
        'inputOptions' => [
            'class' => 'response-form-payment input input-middle input-money',
            'id' => 'response-payment',
        ]
    ])->input('number') ?>
    <?= $form->field($model, "comment", [
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
