<?php

use yii\helpers\Html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>

<section class="modal enter-form form-modal" id="enter-form">
    <h2>Вход на сайт</h2>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'method' => 'post',
        'action' => 'sign/login',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'options' => [
                'style' => 'margin-bottom: 10px',
                'tag' => 'p'
            ],
            'inputOptions' => [
                'class' => 'enter-form-email input input-middle',
                'style' => 'margin-bottom: 0'],
            'errorOptions' => [
                'tag' => 'span',
                'style' => 'margin-top: 5px; color: #FF116E;'
            ],
            'labelOptions' => ['class' => 'form-modal-description'],
        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnBlur' => true,
        'validationStateOn' => 'input',
        'errorCssClass' => 'input-danger',
    ]); ?>
    <?= $form->field($model, 'err', [
        'options' => [
            'style' => 'margin-top: 10px;'
        ],
        'inputOptions' => [
            'type' => 'hidden',
        ]
    ])->label(false); ?>
    <?= $form->field($model, 'email')
        ->textInput([
            'id' => 'enter-email',
            'type' => 'email'
        ]) ?>
    <?= $form->field($model, "password")
        ->passwordInput([
            'id' => 'enter-password'
        ]) ?>
    <a class="button button-vk"
       href="<?= Url::toRoute(['sign/auth', 'authclient' => 'vkontakte']) ?>"
       style="width: 116px; height: 16.5px; display: inline-block; padding-top: 8px; padding-bottom: 22px; padding-left: 10px; padding-right: 10px; text-align: center">
        Вход через ВК
    </a>
    <?= Html::submitButton('Войти',
        ['class' => 'button']) ?>
    <?php ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
