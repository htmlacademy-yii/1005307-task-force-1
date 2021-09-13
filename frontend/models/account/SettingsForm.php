<?php
declare(strict_types=1);

namespace frontend\models\account;

use frontend\models\categories\Categories;
use frontend\models\cities\Cities;
use yii\base\BaseObject;
use yii\base\Model;
use frontend\models\users\Users;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use frontend\models\users\UserCategory;

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
    public $city_id;
    public $specializations;
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
            'city_id' => 'Город',
            'bd' => 'День рождения',
            'about' => 'Информация о себе',
        ];
    }

    public function rules(): array
    {
        return [
            [['email', 'about', 'city_id', 'bd', 'avatar', 'phone', 'skype', 'telegram', 'specializations'], 'safe'],
            [['email'], 'email', 'message' => "Введите корректный email"],
            [['avatar'], 'file'],
              //    [['about'], 'required', 'message' => 'нужен'],
            //        ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => Users::class,
            //           'message' => "Пользователь с еmail «{value}» уже зарегистрирован",
            //           'when' => function ($model, $attribute) {
            //                return $attribute !== \Yii::$app->user->identity->email;
            //            }],

        ];
    }

    public function loadCurrentUserData(Users $user): void
    {
        $this->attributes = $user->attributes;
    }

    public function saveProfileData(Users $user): bool
    {
        $this->validate();
        if (!$this->hasErrors()) {
            $this->saveCommonData($user);
            $this->saveAvatar();
            $this->saveCategories($user);
            $this->checkRole($user);

            return true;
        }

        $this->getErrors();
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

    public function saveAvatar(): bool
    {
        $this->avatar = UploadedFile::getInstance($this, 'avatar');
        if (!empty($this->avatar)) {

            if (!$this->hasErrors()) {
                $errors = $this->getErrors();
            }
            if ($this->validate()) {
                $this->avatar->saveAs('uploads/' . $this->avatar->baseName . '.' . $this->avatar->extension);
            }
            return true;
        }

        return false;
    }

    private function saveCategories(Users $user): void
    {
        foreach ($this->specializations ?? [] as $id) {
            $userCategory = new UserCategory(['category_id' => $id, 'user_id' => $user->id]);
            $userCategory->save();
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
        if ($this->specializations === []) {
            $user->user_role = 'client';
        } else {
            $user->user_role = 'doer';
        }
        $user->save(false, ['user_role']);
    }
}
