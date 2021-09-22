<?php
declare(strict_types=1);

namespace frontend\models\account;

use frontend\models\categories\Categories;
use frontend\models\cities\Cities;
use frontend\models\users\UserCategory;
use frontend\models\users\UserOptionSettings;
use frontend\models\users\Users;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ProfileForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_repeat;
    public $user;
    public $bd;
    public $avatar;
    public $about;
    public $phone;
    public $skype;
    public $telegram;
    public $city_id;
    public $specializations;
    public $optionSet;
    private $cities;
    private $existingSpecializations;

    public function getExistingSpecializations(): array
    {
        if (!isset($this->existingSpecializations)) {
            $this->existingSpecializations = ArrayHelper::map(Categories::getAll(), 'id', 'name');
        }

        return $this->existingSpecializations;
    }

    public function getCities(): array
    {
        if (!isset($this->cities)) {
            $this->cities = ArrayHelper::map(Cities::getAll(), 'id', 'city');
        }

        return $this->cities;
    }

    public function attributeLabels(): array
    {
        return [
            'avatar' => 'Сменить аватар',
            'name' => 'Ваше имя',
            'email' => 'email',
            'password' => 'Новый пароль',
            'password_repeat' => 'Повтор пароля',
            'city_id' => 'Город',
            'bd' => 'День рождения',
            'about' => 'Информация о себе',
        ];
    }

    public function rules(): array
    {
        return [
            [['avatar'], 'image',
                'extensions' => 'jpeg, png, jpg',
                'message' => 'Загружаемый файл должен быть изображением'],
            ['bd', 'date', 'format' => 'yyyy*MM*dd',
                'message' => 'Необходимый формат «гггг.мм.дд»'],
            [['email'], 'required',
                'message' => "Это поле необходимо заполнить"],
            [['email'], 'email',
                'message' => "Введите корректный email"],
            ['email', 'unique',
                'targetAttribute' => 'email',
                'targetClass' => Users::class,
                'message' => "Пользователь с еmail «{value}» уже зарегистрирован",
                'when' => function () {
                    return $this->email !== Yii::$app->user->identity->email;
                }],
            ['password_repeat', 'compare',
                'compareAttribute' => 'password',
                'message' => 'Должен совпадать с паролем из поля «НОВЫЙ ПАРОЛЬ»'],
            ['password', 'compare',
                'message' => 'Должен совпадать с паролем из поля «ПОВТОР ПАРОЛЯ»'],
            ['phone', 'match',
                'pattern' => "/^\d{11}$/",
                'message' => 'Введите 11-значное число'],
            [['skype', 'telegram'], 'match',
                'pattern' => "/^[a-zA-Z0-9]{3,}$/",
                'message' => 'Значение должно состоять из латинских символов и цифр, от 3-х знаков в длину'],
            [['avatar', 'email', 'password', 'password_repeat', 'about', 'city_id', 'bd', 'phone', 'skype', 'telegram', 'specializations', 'optionSet'], 'safe'],
        ];
    }

    public function loadCurrentUserData(Users $user): void
    {
        $this->attributes = $user->attributes;
        $password = $this->password;

        foreach ($user->userCategories as $specialization) {
            $this->specializations[] = $specialization->id;
        }

        $optionSet = $user->optionSet;

        foreach ($optionSet ? $optionSet->attributes : [] as $name => $value) {
            if ($value && $name !== 'user_id') {
                $this->optionSet[] = $name;
            }
        }

        $this->password = $password;
    }

    public function saveProfileData(Users $user)
    {
        $this->saveAvatar();
        $this->saveCategories($user);
        $this->checkRole($user);
        $this->saveOptionSet($user);
        $this->saveCommonData($user);
    }

    private function saveCommonData(Users $user): void
    {
        $user->setScenario(Users::SCENARIO_UPDATE);
        $user->setAttributes($this->attributes);
        $attributesToBeSaved = [];

        if (isset($this->password)) {
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->save(false, ['password']);
        }

        foreach ($user->attributes as $name => $value) {
            if (!empty($value)) {
                $attributesToBeSaved[] = $name;
            }
        }

        $user->save(false, $attributesToBeSaved);
    }

    private function saveAvatar(): void
    {
        if (!empty($this->avatar)) {
            $this->avatar->saveAs('uploads/' . $this->avatar->baseName . '.' . $this->avatar->extension);
        }
    }

    private function saveCategories(Users $user): void
    {
        foreach ($this->specializations ?? [] as $id) {
            if (!UserCategory::findOne(['user_id' => $user->id, 'category_id' => $id])) {
                $userCategory = new UserCategory(['category_id' => $id, 'user_id' => $user->id]);
                $userCategory->save();
            }
        }

        foreach ($this->getExistingSpecializations() as $id => $name) {
            if (!in_array($id, $this->specializations ?? [])) {
                $specializationToBeDeleted = UserCategory::findOne(['user_id' => $user->id, 'category_id' => $id]);

                if ($specializationToBeDeleted !== null) {
                    $specializationToBeDeleted->delete();
                }
            }
        }
    }

    private function checkRole(Users $user): void
    {
        if ($user->userCategories === []) {
            $user->user_role = 'client';
        } else {
            $user->user_role = 'doer';
        }
        $user->save(false, ['user_role']);
    }

    private function saveOptionSet(Users $user): void
    {
        $optionSet = $user->optionSet;

        if ($optionSet === null) {
            $optionSet = new UserOptionSettings();
        }

        foreach ($optionSet->attributes as $name => $value) {
            if ($name !== 'id') {
                $optionSet->$name = $name !== 'user_id' ? 0 : $user->id;
            }
        }

        foreach ($this->optionSet ?? [] as $name) {
            if ($name !== 'id') {
                $optionSet->$name = 1;
            }
        }

        $optionSet->save(false);
    }
}
