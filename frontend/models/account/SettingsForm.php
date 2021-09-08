<?php
declare(strict_types = 1);

namespace frontend\models\account;

use yii\base\Model;
use frontend\models\users\Users;

class SettingsForm extends Model
{
    public $name;
    public $email;
    public $user;
    public $bd;

    public $about;

    public function attributeLabels(): array
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'email',
            'about' => 'Информация о себе',
            'bd' => 'День рождения',
        ];
    }

    public function rules(): array
    {
        return [
       //     [['email'], 'message' => "Поле «{attribute}» не может быть пустым"],
            [['email', 'about', 'bd'], 'safe'],
        ];
    }

    public function saveProfileData(Users $user): bool
    {
        $this->validate();
        if (!$this->hasErrors()) {
            $this->saveCommonData($user);

            return true;
        }

        return false;
    }

    private function saveCommonData(Users $user): void
    {
        $user->setScenario(Users::SCENARIO_UPDATE);
        $user->setAttributes($this->attributes);
        $attributesToBeSaved = [];

        foreach ($user->attributes as $name => $value) {
            if (!empty($value)) {
                $attributesToBeSaved[] = $name;
            }
        }

        $user->save(false, $attributesToBeSaved);
    }
}
