<?php
$this->title = 'Редактирование настроек пользователя';

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$cities = $settingsForm->getCities();
$specializations = $settingsForm->getExistingSpecializations();

//$categories = $createTaskForm->getCategories();

?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="account__redaction-wrapper">
            <h1>Редактирование настроек профиля</h1>
            <?php $form = ActiveForm::begin([
                'id' => 'account',
                'method' => 'post',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'options' => [
                    'enctype' => "multipart/form-data",
                    'tag' => false,
                ],
                'validationStateOn' => 'input',
                'action' => '/settings/index',
                'validateOnBlur' => true,
                'validateOnChange' => true,
                'validateOnSubmit' => true,
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'options' => [
                        'tag' => false
                    ],
                    'inputOptions' => [
                        'class' => 'input textarea',
                    ],
                    'errorOptions' => [
                        'tag' => 'span',
                        'style' => 'color: red; display: block'
                    ],
                    'labelOptions' => [
                        'class' => null,
                    ],
                ]]) ?>
            <div class="account__redaction-section">
                <h3 class="div-line">Настройки аккаунта</h3>
                <div class="account__redaction-section-wrapper">
                    <div class="account__redaction-avatar">
                        <?= $user['avatar']
                            ? Html::img(Yii::$app->request->baseUrl . '/img/' . $user['avatar'], ['alt' => 'Аватар пользователя', 'width' => '156', 'height' => '156'])
                            : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '156', 'height' => '156']) ?>
                        <?= $form->field($settingsForm, 'avatar', [
                            'inputOptions' => [
                                'class' => 'create__file',
                                'style' => 'display: none',
                                'id' => 'upload-avatar',

                                'widgetClientOptions' => [
                                    'buttonsHide' => ['image', 'file'],
                                ]
                            ],
                            'labelOptions' => [
                                'class' => 'link-regular',
                                'for' => 'upload-avatar'
                            ],
                            'options' => [
                                'tag' => false,
                            ],
                        ])->label()->fileInput(['accept' => 'image/*']); ?>
                    </div>
                    <div class="account__redaction">
                        <div class="account__input account__input--name">
                            <?= $form->field($settingsForm, 'name', [
                                'inputOptions' => [
                                    'class' => 'input textarea',
                                    'placeholder' => $user['name'],
                                    'id' => '200',
                                    'type' => 'text',
                                    'style' => 'margin-top: 0',
                                    'disabled' => true
                                ]
                            ]) ?>
                        </div>
                        <div class="account__input account__input--email">
                            <?= $form->field($settingsForm, 'email', [
                                'inputOptions' => [
                                    'class' => 'input textarea',
                                    'id' => '201',
                                    'type' => 'text',
                                    'style' => 'margin-top: 0',
                                ]
                            ]) ?>
                        </div>
                        <div class="account__input account__input--name">
                            <?= $form->field($settingsForm, "city_id")
                                ->dropDownList($cities, [
                                    'class' => 'multiple-select input multiple-select-big',
                                    'size' => 1,
                                    'id' => 202,
                                    'options' => array(
                                        $user['city_id'] => ['label' => $user['city']['city'], 'selected' => true],
                                    ),
                                ]) ?>
                        </div>
                        <div class="account__input account__input--date">
                            <?= $form->field($settingsForm, 'bd', [
                                'inputOptions' => [
                                    'class' => 'input-middle input input-date',
                                    'id' => '203',
                                    'type' => 'date',
                                    'max' => '2010-12-31'
                                ]
                            ]) ?>
                        </div>
                        <div class="account__input account__input--info">
                            <?= $form->field($settingsForm, 'about', [
                                'inputOptions' => [
                                    'class' => 'input textarea',
                                    'placeholder' => 'Place your text',
                                    'id' => '201',
                                    'type' => 'text',
                                ]
                            ])->textArea() ?>
                        </div>
                    </div>
                </div>

                <h3 class="div-line">Выберите свои специализации</h3>
                <div class="account__redaction-section-wrapper">
                    <div class="search-task__categories account_checkbox--bottom">
                        <?= $form->field($settingsForm, 'specializations', [
                            'options' => ['class' => 'search-task__categories account_checkbox--bottom'],
                            'template' => "{input}"
                        ])->checkboxList($specializations, [
                            'tag' => false,
                            'unselect' => null,
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return '<input id="' . $index . '" name="' . $name . '" value="' . $value . '" '
                                    . 'type="checkbox" class="visually-hidden checkbox__input" '
                                    . ($checked ? 'checked ' : '') . '>'
                                    . '<label for="' . $index . '">' . $label . '</label>';
                            }
                        ]); ?>
                    </div>
                </div>
                <h3 class="div-line">Безопасность</h3>
                <div class="account__redaction-section-wrapper account__redaction">
                    <div class="account__input">
                        <?= $form->field($settingsForm, 'password', [
                            'options' => ['class' => 'account__input'],
                            'inputOptions' => ['class' => 'input textarea']
                        ])->passwordInput(['maxlength' => 6]); ?>
                    </div>
                    <div class="account__input">
                        <?= $form->field($settingsForm, 'password_repeat', [
                            'options' => ['class' => 'account__input'],
                            'inputOptions' => ['class' => 'input textarea', 'value' => $user['password']]
                        ])->passwordInput(); ?>
                    </div>
                </div>
                <h3 class="div-line">Фото работ</h3>
                <div class="account__redaction-section-wrapper account__redaction">
                    <span class="dropzone">
                        <?php foreach ($user->portfolioPhotos as $photo): ?>
                            <a><img alt="Фото работы" width="120px" height="120px" src=""></a>
                        <?php endforeach; ?>
                        <?= $form->field($settingsForm, 'portfolio_photo[]', [
                            'inputOptions' => [
                                'class' => 'create__file',
                                'style' => 'display: none',
                                'multiple' => true,
                                'id' => 'file_task',

                                'widgetClientOptions' => [
                                    'buttonsHide' => ['image', 'file'],
                                ]
                            ],
                            'options' => [
                                'tag' => false,
                            ],
                        ])->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
                    </span>
                </div>
                <h3 class="div-line">Контакты</h3>
                <div class="account__redaction-section-wrapper account__redaction">
                    <div class="account__input">
                        <?= $form->field($settingsForm, 'phone', [
                            'inputOptions' => [
                                'class' => 'input textarea',
                                'id' => '213',
                                'type' => 'text',
                                'style' => 'margin-top: 0',
                            ]
                        ]) ?>
                    </div>
                    <div class="account__input">
                        <?= $form->field($settingsForm, 'skype', [
                            'inputOptions' => [
                                'class' => 'input textarea',
                                'id' => '214',
                                'type' => 'text',
                                'style' => 'margin-top: 0',
                            ]
                        ]) ?>
                    </div>
                    <div class="account__input">
                        <?= $form->field($settingsForm, 'telegram', [
                            'inputOptions' => [
                                'class' => 'input textarea',
                                'id' => '215',
                                'type' => 'text',
                                'style' => 'margin-top: 0',
                            ]
                        ]) ?>
                    </div>
                </div>
                <h3 class="div-line">Настройки сайта</h3>
                <h4>Уведомления</h4>
                <div class="account__redaction-section-wrapper account_section--bottom">
                    <?= $form->field($settingsForm, 'optionSet', [
                        'template' => "{input}"
                    ])->checkboxList([
                        'is_subscribed_messages' => 'Новое сообщение',
                        'is_subscribed_actions' => 'Действия по заданию',
                        'is_subscribed_options' => 'Новый отзыв',
                        'is_hidden_contacts' => 'Показывать мои контакты только заказчику',
                        'is_hidden_account' => 'Не показывать мой профиль',
                    ],
                        [
                            'tag' => false,
                            'unselect' => null,
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return ($index == 0 ? '<div class="search-task__categories account_checkbox--bottom">' : '')
                                    . '<input id="' . $value . '" name="' . $name . '" value="' . $value . '" '
                                    . 'type="checkbox" class="visually-hidden checkbox__input" '
                                    . ($checked ? 'checked ' : '') . '>'
                                    . '<label for="' . $value . '">' . $label . '</label>'
                                    . ($index == 2 ? '</div><div class="search-task__categories account_checkbox '
                                        . 'account_checkbox--secrecy">' : '')
                                    . ($index == 4 ? '</div>' : '');
                            }
                        ]); ?>
                </div>
            </div>
            <button class="button" type="submit">Сохранить изменения</button>
            <?php ActiveForm::end(); ?>
        </section>
    </div>
</main>

