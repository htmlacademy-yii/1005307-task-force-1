<?php
$this->title = 'Редактирование настроек пользователя';

use yii\widgets\ActiveForm;

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
                        'style' => 'margin-top: 29px',
                        'tag' => false
                    ],
                    'inputOptions' => [
                        'class' => 'input textarea',
                    ],
                    'errorOptions' => [
                        'tag' => 'span',
                        'style' => 'color: red'
                    ],
                    'labelOptions' => [
                        'class' => null,
                    ],
                ]]) ?>
                <div class="account__redaction-section">
                    <h3 class="div-line">Настройки аккаунта</h3>
                    <div class="account__redaction-section-wrapper">
                        <div class="account__redaction-avatar">
                            <img src="./img/man-glasses.jpg" width="156" height="156">
                            <input type="file" name="avatar" id="upload-avatar">
                            <label for="upload-avatar" class="link-regular">Сменить аватар</label>
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
                                        'placeholder' => $user['email'],
                                        'id' => '201',
                                        'type' => 'text',
                                        'style' => 'margin-top: 0',
                                    ]
                                ]) ?>
                            </div>
                            <div class="account__input account__input--name">
                                <label for="202">Город</label>
                                <select class="multiple-select input multiple-select-big" size="1" id="202"
                                        name="town[]">
                                    <option value="Moscow">Москва</option>
                                    <option selected="" value="SPB">Санкт-Петербург</option>
                                    <option value="Krasnodar">Краснодар</option>
                                    <option value="Irkutsk">Иркутск</option>
                                    <option value="Vladivostok">Владивосток</option>
                                </select>
                            </div>
                            <div class="account__input account__input--date">
                                <?= $form->field($settingsForm, 'bd', [
                                    'inputOptions' => [
                                        'class' => 'input-middle input input-date',
                                        'id' => '203',
                                        'type' => 'date',
                                        'placeholder' => $user['bd']
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
                                        'style' => 'margin-top: 0',
                                    ]
                                ])->textArea()->hint('Пожалуйста, введите имя') ?>
                            </div>
                        </div>
                    </div>
                    <h3 class="div-line">Выберите свои специализации</h3>
                    <div class="account__redaction-section-wrapper">
                        <div class="search-task__categories account_checkbox--bottom">
                            <input class="visually-hidden checkbox__input" id="205" type="checkbox" name="" value=""
                                   checked>
                            <label for="205">Курьерские услуги</label>
                            <input class="visually-hidden checkbox__input" id="206" type="checkbox" name="" value=""
                                   checked>
                            <label for="206">Грузоперевозки</label>
                            <input class="visually-hidden checkbox__input" id="207" type="checkbox" name="" value="">
                            <label for="207">Перевод текстов</label>
                            <input class="visually-hidden checkbox__input" id="208" type="checkbox" name="" value=""
                                   checked>
                            <label for="208">Ремонт транспорта</label>
                            <input class="visually-hidden checkbox__input" id="209" type="checkbox" name="" value="">
                            <label for="209">Удалённая помощь</label>
                            <input class="visually-hidden checkbox__input" id="210" type="checkbox" name="" value="">
                            <label for="210">Выезд на стрелку</label>
                        </div>
                    </div>
                    <h3 class="div-line">Безопасность</h3>
                    <div class="account__redaction-section-wrapper account__redaction">
                        <div class="account__input">
                            <label for="211">Новый пароль</label>
                            <input class="input textarea" type="password" id="211" name="" value="moiparol">
                        </div>
                        <div class="account__input">
                            <label for="212">Повтор пароля</label>
                            <input class="input textarea" type="password" id="212" name="" value="moiparol">
                        </div>
                    </div>
                    <h3 class="div-line">Контакты</h3>
                    <div class="account__redaction-section-wrapper account__redaction">
                        <div class="account__input">
                            <label for="213">Телефон</label>
                            <input class="input textarea" type="tel" id="213" name="" placeholder="8 (555) 187 44 87">
                        </div>
                        <div class="account__input">
                            <label for="214">Skype</label>
                            <input class="input textarea" type="password" id="214" name="" placeholder="DenisT">
                        </div>
                        <div class="account__input">
                            <label for="215">Telegram</label>
                            <input class="input textarea" id="215" name="" placeholder="@DenisT">
                        </div>
                    </div>
                    <h3 class="div-line">Настройки сайта</h3>
                    <h4>Уведомления</h4>
                    <div class="account__redaction-section-wrapper account_section--bottom">
                        <div class="search-task__categories account_checkbox--bottom">
                            <input class="visually-hidden checkbox__input" id="216" type="checkbox" name="" value=""
                                   checked>
                            <label for="216">Новое сообщение</label>
                            <input class="visually-hidden checkbox__input" id="217" type="checkbox" name="" value=""
                                   checked>
                            <label for="217">Действия по заданию</label>
                            <input class="visually-hidden checkbox__input" id="218" type="checkbox" name="" value=""
                                   checked>
                            <label for="218">Новый отзыв</label>
                        </div>
                        <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                            <input class="visually-hidden checkbox__input" id="219" type="checkbox" name="" value="">
                            <label for="219">Показывать мои контакты только заказчику</label>
                            <input class="visually-hidden checkbox__input" id="220" type="checkbox" name="" value=""
                                   checked>
                            <label for="220">Не показывать мой профиль</label>
                        </div>
                    </div>
                </div>
                <button class="button" type="submit">Сохранить изменения</button>
                <?php ActiveForm::end(); ?>
        </section>
    </div>
</main>
