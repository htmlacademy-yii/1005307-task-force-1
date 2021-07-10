<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FileUploadForm extends Model
{
    public $file_item;
    public $task_id;

    //private $filePathTemplate = "{basePath}/uploads/{task_id}";

    //private $filePathTemplate = "{basePath}/uploads/{task_id}";
    //private $_folderPath;

    public function rules(): array
    {
        return [
            ['file_item', 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, jpeg doc, docx, pdf',
                'maxFiles' => 5,
                'message' => 'Файлы могут быть только форматов png, jpg, jpeg doc, docx, pdf'],
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
