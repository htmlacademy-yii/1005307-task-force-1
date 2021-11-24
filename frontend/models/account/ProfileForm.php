<?php
declare(strict_types=1);

namespace frontend\models\account;

use frontend\models\{categories\Categories, users\UserCategory, users\Users};
use Yii;
use yii\base\Model;

class ProfileForm extends Model
{
    public $about;
    public $avatar;
    public $birthday;
    public $city_id;
    public $email;
    public $name;
    public $optionSet;
    public $password;
    public $password_repeat;
    public $phone;
    public $photo;
    public $skype;
    public $specializations;
    public $telegram;
    public $user;

    public function rules(): array
    {
        return [
            [['avatar'], 'file',
                'extensions' => 'jpeg, png, jpg',
                'message' => 'Загружаемый файл должен быть изображением'],
            ['birthday', 'date', 'format' => 'yyyy*MM*dd',
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
            [['photo'], 'file',
                'extensions' => "jpeg, png, jpg",
                'maxFiles' => 6,
                'message' => 'Загружаемый файл должен быть изображением в формате jpeg, png'],
            ['phone', 'match',
                'pattern' => "/^\d{11}$/",
                'message' => 'Введите 11-значное число'],
            ['skype', 'match',
                'pattern' => "/^[a-zA-Z0-9]{3,}$/",
                'message' => 'Значение должно состоять из латинских символов и цифр, от 3-х знаков в длину'],
            [['avatar', 'email', 'password', 'password_repeat', 'about', 'city_id', 'birthday', 'phone', 'skype', 'telegram', 'specializations', 'optionSet', 'photo'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'about' => 'Информация о себе',
            'avatar' => 'Сменить аватар',
            'birthday' => 'День рождения',
            'city_id' => 'Город',
            'email' => 'email',
            'name' => 'Ваше имя',
            'password' => 'Новый пароль',
            'password_repeat' => 'Повтор пароля',
            'photo' => 'Выбрать фотографии',
        ];
    }

    public function getExistingSpecializations(): array
    {
        return Categories::getCategoriesFilters();
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

    public function saveProfileData(Users $user): void
    {
        $this->saveAvatar();
        $this->saveCategories($user);
        $this->saveCommonData($user);
        $this->checkRole($user);
        $this->saveOptionSet($user);
    }

    public function upload(): bool
    {
        if (!empty($this->photo && $this->validate($this->photo))) {
            foreach ($this->photo as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        }
        return false;
    }

    private function saveAvatar(): void
    {
        if (!empty($this->avatar)) {
            $this->avatar->saveAs('uploads/' . $this->avatar->baseName . '.' . $this->avatar->extension);
            $this->avatar = '/uploads/' . $this->avatar;
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

        $user->save(true, $attributesToBeSaved);
    }

    private function saveOptionSet(Users $user): void
    {
        $optionSet = $user->optionSet;

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

    private function checkRole(Users $user): void
    {
        if ($user->userCategories === []) {
            $user->user_role = 'client';
        } else {
            $user->user_role = 'doer';
        }
        $user->save(false, ['user_role']);
    }
}
