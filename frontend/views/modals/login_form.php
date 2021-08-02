<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<section class="modal enter-form form-modal" id="enter-form">
    <h2>Вход на сайт</h2>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'method' => 'post',
        'action' => 'sign/login',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'inputOptions' => ['class' => 'enter-form-email input input-middle'],
            'errorOptions' => ['tag' => 'span', 'style' => 'margin: -30px 0 20px;', 'color: #FF116E;'],
            'options' => ['tag' => 'p'],
            'labelOptions' => ['class' => 'form-modal-description'],
        ],
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'validationStateOn' => 'input',
        'errorCssClass' => 'input-danger',
    ]); ?>
    <?= $form->field($model, 'email',
        ['enableAjaxValidation' => true])
        ->textInput(['id' => 'enter-email',
            'type' => 'email']) ?>
    <?= $form->field($model, "password",
        ['enableAjaxValidation' => true])
        ->passwordInput([
            'id' => 'enter-password'
        ]) ?>
    <?= Html::submitButton('Войти',
        ['class' => 'button']) ?>
    <?php ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
