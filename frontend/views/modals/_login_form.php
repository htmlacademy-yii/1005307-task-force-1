<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<section class="modal enter-form form-modal" id="enter-form" style="display: block">
    <h2>Вход на сайт</h2>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'method' => 'post',
        'action' => 'sign/login',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'inputOptions' => ['class' => 'enter-form-email input input-middle'],
            'errorOptions' => [
                'tag' => 'span',
                'style' => 'margin: -30px 0 20px; color: #FF116E;'
            ],
            'options' => ['tag' => 'p'],
            'labelOptions' => ['class' => 'form-modal-description'],
        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnBlur' => true,
        'validationStateOn' => 'input',
        'errorCssClass' => 'input-danger',
    ]); ?>
    <?php if (Yii::$app->session->hasFlash('form-errors')): ?>
        <p style="color: #FF116E;">Вы ввели неверный email/пароль</p>
    <?php endif; ?>
    <?= $form->field($model, 'email',
        ['enableAjaxValidation' => true])
        ->textInput([
            'id' => 'enter-email',
            'type' => 'email'
        ]) ?>
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
