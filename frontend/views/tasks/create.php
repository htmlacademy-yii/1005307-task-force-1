<?php
$this->title = 'Публикация нового задания';

use frontend\models\users\Users;
use frontend\models\cities\Cities;
use yii\widgets\ActiveForm;

$categories = new \frontend\models\categories\Categories();
$categories = $categories->getCategoriesFilters();
$user = Users::findOne($user->id);

?>

<div class="main-container page-container">
    <section class="create__task">
        <h1>Публикация нового задания</h1>
        <div class="create__task-main">
            <?php $form = ActiveForm::begin([
                'id' => 'task-form',
                'method' => 'post',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'options' => [
                    'class' => 'create__task-form form-create',
                    'enctype' => "multipart/form-data",
                    'tag' => false,
                ],
                'validationStateOn' => 'input',
                'action' => '/task/create',
                'validateOnBlur' => true,
                'validateOnChange' => true,
                'validateOnSubmit' => true,
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'options' => [
                        'style' => 'margin-top: 29px'
                    ],
                    'inputOptions' => [
                        'class' => 'input textarea',
                        'style' => 'width: 93%; margin-top: 12px; margin-bottom: 8px;',
                    ],
                    'errorOptions' => [
                        'tag' => 'span',
                        'style' => 'color: red'
                    ],
                    'labelOptions' => [
                        'class' => null,
                    ],
                ]]) ?>
            <?= $form->field($createTaskForm, 'client_id', [
                'options' => ['style' => 'margin-top: 0'],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'value' => $user['id'],
                    'type' => 'hidden',
                    'style' => 'margin-top: 0'
                ]
            ])->label(false); ?>
            <?= $form->field($createTaskForm, 'status_task', [
                'options' => ['style' => 'margin-top: 0'],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'value' => 'Новое',
                    'type' => 'hidden',
                    'style' => 'margin-top: 0'
                ]
            ])->label(false); ?>
            <?= $form->field($createTaskForm, "name", [
                'inputOptions' => [
                    'class' => 'input textarea',
                    'id' => 10,
                    'rows' => 1,
                ],
                'options' => [
                    'tag' => false,
                ],
            ])->textArea()->hint('Пожалуйста, введите имя') ?>
            <?= $form->field($createTaskForm, "description", [
                'inputOptions' => [
                    'class' => 'input textarea',
                    'id' => 11,
                    'rows' => 7,
                ],
                'options' => [
                    'tag' => false,
                ],
            ])->textArea() ?>
            <label>Файлы</label>
            <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
            <div class="create__file" style="position: relative">
                <span>Добавить новый файл</span>
                <label for="file_task" style="position: absolute; width: 100%; height: 100%;">
                    <?= $form->field($createTaskForm, 'file_item[]', [
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
                    ])->label(false)->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
                </label>
            </div>
            <?php $js = <<<JS
                    const fileSpan = document.querySelector('.create__file span');
                    file_task.addEventListener('change', (event) => {
                        const fileList = event.target.files;
                        if (fileList.length === 1) {
                            fileSpan.textContent = 'Загружен ' + fileList.length + ' файл';
                        }
                        if (fileList.length > 1) {
                            fileSpan.textContent = 'Загружены ' + fileList.length + ' файла';
                        }
                        if (fileList.length > 4) {
                            fileSpan.textContent = 'Загружено ' + fileList.length + ' файлов';
                        }
                    })
JS;
            $this->registerJs($js);
            ?>
            <?= $form->field($createTaskForm, "category_id", [
                'options' => [
                    'tag' => false,
                ],
                'inputOptions' => [
                    'style' => 'width: 520px; margin-top: 12px; margin-bottom: 7px;',
                    'id' => '13'
                ],
            ])->dropDownList($categories, [
                'class' => 'multiple-select input multiple-select-big',
                'prompt' => [
                    'text' => 'Выберите категорию',
                    'options' => ['value' => '0']
                ]
            ]) ?>
            <?= $form->field($createTaskForm, "address", [
                'inputOptions' => [
                    'class' => 'input-navigation input-middle input',
                    'id' => 'address',
                    'rows' => 1,
                ],
                'options' => [
                    'tag' => false,
                ],
                'template' =>
                    "{label}\n{input}\n"
                    . "<span>Укажите адрес исполнения, если задание требует присутствия</span>",

            ])->input('text') ?>
            <div class="create__price-time">
                <div class="create__price-time--wrapper">
                    <?= $form->field($createTaskForm, "budget", [
                        'options' => [
                            'style' => 'margin-top: 0',
                            'tag' => false,
                        ],
                        'inputOptions' => [
                            'class' => 'input textarea input-money',
                            'id' => 15,
                            'rows' => 1
                        ]
                    ])->input('number') ?>
                </div>
                <div class="create__price-time--wrapper">
                    <?= $form->field($createTaskForm, "expire", [
                        'options' => [
                            'style' => 'margin-top: 0',
                            'tag' => false,
                        ],
                        'inputOptions' => [
                            'class' => 'input-middle input input-date',
                            'id' => 16,
                            'rows' => 1,
                        ]
                    ])->input('date') ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="create__warnings">
                <div class="warning-item warning-item--advice">
                    <h2>Правила хорошего описания</h2>
                    <h3>Подробности</h3>
                    <p>Друзья, не используйте случайный<br>
                        контент – ни наш, ни чей-либо еще. Заполняйте свои
                        макеты, вайрфреймы, мокапы и прототипы реальным
                        содержимым.</p>
                    <h3>Файлы</h3>
                    <p>Если загружаете фотографии объекта, то убедитесь,
                        что всё в фокусе, а фото показывает объект со всех
                        ракурсов.</p>
                </div>
                <?php if (Yii::$app->session->hasFlash('form-errors')):
                    $allErrors = Yii::$app->session->getFlash('form-errors'); ?>
                    <div class="warning-item warning-item--error">
                        <h2>Ошибки заполнения формы</h2>
                        <p>Данные формы не прошли валидацию</p>
                        <?php $labels = $createTaskForm->attributeLabels();
                        foreach ($allErrors as $attribute => $message): ?>
                            <h3><?= $labels[$attribute] ?></h3>
                            <p><?= $message[0] ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <button form="task-form" class="button" type="submit">Опубликовать</button>
    </section>
</div>
<?php if ($this->title === 'Публикация нового задания'): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.6.0/dist/css/suggestions.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.6.0/dist/js/jquery.suggestions.min.js"></script>

    <script type="text/javascript">
        <?php $session = Yii::$app->session;
        $city = Cities::findOne($session->get('city'));?>
        $("#address").suggestions({
            token: "5e9234412c360c19d520220cc87dc076c8e65389",
            type: "ADDRESS",
            constraints: {
                locations: {region: "<?= $city['city'] ?>"},
            },
            restrict_value: true
        })
    </script>
<?php endif; ?>
