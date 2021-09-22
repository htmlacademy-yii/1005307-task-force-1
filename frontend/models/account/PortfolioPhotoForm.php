<?php
declare(strict_types=1);

namespace frontend\models\account;

use yii\base\Model;

class PortfolioPhotoForm extends Model
{
    public $photo;
    public $user_id;

    public function rules(): array
    {
        return [
            [['photo'], 'file',
                'extensions' => "jpeg, png, jpg",
                'maxFiles' => 6,
                'message' => 'Загружаемый файл должен быть изображением в формате jpeg, png'],
            [['user_id', 'photo'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'photo' => 'Выбрать фотографии',
            'user_id' => 'Пользователь'
        ];
    }

    public function upload(): bool
    {
        if (!empty($this->photo)) {

            if (!$this->validate()) {
                $errors = $this->getErrors();
            }
            if ($this->validate()) {
                foreach ($this->photo as $file) {
                    $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                }
            }
            return true;
        }

        return false;
    }
}
