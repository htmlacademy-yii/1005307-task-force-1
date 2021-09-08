<?php
declare(strict_types=1);

namespace frontend\models\account;

use yii\base\Model;
use frontend\models\users\Users;
use yii\web\UploadedFile;

class SettingsForm extends Model
{
    public $name;
    public $email;
    public $user;
    public $bd;
    public $avatar;
    public $about;
    public $phone;
    public $skype;
    public $telegram;

    public function attributeLabels(): array
    {
        return [
            'name' => 'Ваше имя',
            'avatar' => 'Сменить аватар',
            'email' => 'email',
            'about' => 'Информация о себе',
            'bd' => 'День рождения',
        ];
    }

    public function rules(): array
    {
        return [
            [['email'], 'email', 'message' => "Введите корректный email"],
            [['avatar'], 'file'],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => Users::class,
                'message' => "Пользователь с еmail «{value}» уже зарегистрирован",
                'when' => function ($model, $attribute) {
                    return $attribute !== \Yii::$app->user->identity->email;
                }],
            [['email', 'about', 'bd', 'avatar', 'phone', 'skype', 'telegram'], 'safe'],

        ];
    }

    public function saveProfileData(Users $user): bool
    {
        if ($this->validate()) {
            $this->avatar = UploadedFile::getInstance($this, 'avatar');
            $this->upload();
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
