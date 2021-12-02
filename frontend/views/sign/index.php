<?php

use frontend\models\cities\Cities;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация аккаунта';
$cities = new Cities();
$cities = $cities->getCities();
?>

<div class="main-container page-container">
    <section class="registration__user">
        <h1>Регистрация аккаунта</h1>
        <div class="registration-wrapper">
            <?php $form = ActiveForm::begin([
                'action' => '/sign/',
                'id' => 'sign',
                'method' => 'post',
                'options' => ['class' => 'registration__user-form form-create'],
                'validationStateOn' => 'input',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'options' => ['style' => 'margin-bottom: 27px'],
                    'inputOptions' => [
                        'class' => 'input textarea',
                        'style' => 'width: 100%; margin-top: 12px; margin-bottom: 0px;',
                    ],
                    'errorOptions' => [
                        'tag' => 'span',
                        'style' => 'color: red'
                    ],
                ]]) ?>
            <?= $form->field($signForm, 'user_role', [
                'inputOptions' => [
                    'value' => 'client',
                    'type' => 'hidden',
                ]
            ])->label(false); ?>
            <?= $form->field($signForm, "email", [
                'inputOptions' => [
                    'id' => 16,
                    'rows' => 1,
                ]
            ])->textArea() ?>
            <?= $form->field($signForm, "name", [
                'inputOptions' => [
                    'id' => 17,
                    'rows' => 1
                ]
            ])->textArea() ?>
            <?= $form->field($signForm, "city_id")
                ->dropDownList($cities, [
                    'class' => 'multiple-select input town-select registration-town',
                    'size' => 1,
                    'id' => 18
                ]); ?>
            <?= $form->field($signForm, "password", [
                'inputOptions' => [
                    'id' => 19
                ]
            ])->passwordInput() ?>
            <button class="button button__registration" type="submit">Cоздать аккаунт</button>

            <?php ActiveForm::end(); ?>
        </div>
    </section>

</div>
