<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use yii\base\Model;

class FileTaskForm extends Model
{
    public $file_item;
    public $task_id;

    public function rules(): array
    {
        return [
            [['file_item'], 'file',
                'skipOnEmpty' => true],
            [['task_id', 'file_item'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'file_item' => 'Файл',
            'task_id' => 'Задание'
        ];
    }

    public function upload(): bool
    {
        if (!empty($this->file_item)) {

            if (!$this->validate()) {
                $errors = $this->getErrors();
            }
            if ($this->validate()) {
                foreach ($this->file_item as $file) {
                    $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                }
            }
            return true;
        }

        return false;
    }
}
