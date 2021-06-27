<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<section class="modal enter-form form-modal" id="enter-form">
    <h2>Вход на сайт</h2>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'method' => 'post',
        'action' => Url::toRoute('sign/login'),
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'inputOptions' => ['class' => 'enter-form-email input input-middle'],
            'errorOptions' => ['tag' => 'span', 'style' => 'margin: -30px 0 20px;'],
            'options' => ['tag' => 'p'],
            'labelOptions' => ['class' => 'form-modal-description'],
        ],
        'enableAjaxValidation' => true,
        'validationStateOn' => 'input',
        'errorCssClass' => 'input-danger',
    ]); ?>
    <?= $form->field($model, "email", [
        'inputOptions' => [
            'id' => 'enter-email',
            'type' => 'email'
        ]
    ]) ?>
    <?= $form->field($model, "password", [
        'inputOptions' => [
            'id' => 'enter-password'
        ]
    ])->passwordInput() ?>
    <button class="button" type="submit">Войти</button>
    <?php ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
