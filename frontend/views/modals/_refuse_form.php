<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>
        Вы собираетесь отказаться от выполнения задания.
        Это действие приведёт к снижению вашего рейтинга.
        Вы уверены?
    </p>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => '/tasks/refuse']) ?>

    <?= $form->field($model, 'task_id', [
        'inputOptions' => [
            'value' => $this->params['task_id'],
            'type' => 'hidden',
        ]
    ])->label(false); ?>
    <?= Html::submitButton('Отказаться',
        ['class' => 'button__form-modal refusal-button button']) ?>
    <?php ActiveForm::end(); ?>
    <button class="button__form-modal button" id="close-modal"
            type="button">Отмена
    </button>

    <button class="form-modal-close" type="button">Закрыть</button>
</section>
