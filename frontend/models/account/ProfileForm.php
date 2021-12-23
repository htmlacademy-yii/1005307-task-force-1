<?php
declare(strict_types=1);

namespace frontend\models\account;

use frontend\models\{categories\Categories, users\PortfolioPhoto, users\UserCategory, users\Users};
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class ProfileForm
 * @package frontend\models\account
 */
class ProfileForm extends Model
{
    public $about;
    public $avatar;
    public $birthday;
    public $city_id;
    public $email;
    public $existingSpecializations;
    public $name;
    public $optionSet;
    public $password;
    public $password_repeat;
    public $phone;
    public $photo;
    public $skype;
    public $specializations;
    public $specializationToBeDeleted;
    public $telegram;
    public $user;
    public $userCategory;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['avatar', 'file',
                'extensions' => 'jpeg, png, jpg',
                'message' => 'Загружаемый файл должен быть изображением'],
            ['birthday', 'date', 'format' => 'yyyy*MM*dd',
                'message' => 'Необходимый формат «гггг.мм.дд»'],
            ['email', 'required',
                'message' => "Это поле необходимо заполнить"],
            ['email', 'email',
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
            [['about', 'email', 'phone', 'photo', 'skype', 'telegram'], 'trim'],
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
            [['about', 'avatar', 'birthday', 'city_id', 'email', 'name', 'optionSet', 'password', 'password_repeat', 'phone', 'photo', 'skype', 'specializations', 'telegram'], 'safe'],
        ];
    }


    /**
     * {@inheritdoc}
     */
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

    /**
     * Loads current user data
     *
     * @params $user user model whose data loads
     */
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

    /**
     * Saves user data
     * @param Users $user whose data save
     */
    public function saveProfileData(Users $user): void
    {
        $this->saveAvatar();
        $this->saveCategories($user);
        $this->saveCommonData($user);
        $this->checkRole($user);
        $this->saveOptionSet($user);
        $this->upload($user);
    }

    /**
     * Uploads file
     */
    private function upload($user): void
    {
        $this->photo = UploadedFile::getInstances($this, 'photo');
        if (!empty($this->photo && $this->validate($this->photo))) {
            PortfolioPhoto::deleteAll(['user_id' => $user->id]);
            foreach ($this->photo as $file) {
                $portfolioPhoto = new PortfolioPhoto([
                    'photo' => '/uploads/' . $file,
                    'user_id' => $user->id]);
                $portfolioPhoto->save(false);
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
        }
    }

    /**
     * Uploads avatar
     */
    private function saveAvatar(): void
    {
        if (property_exists(new Users, 'avatar')) {
            if (!empty($this->avatar)) {
                $this->avatar->saveAs('uploads/' . $this->avatar->baseName . '.' . $this->avatar->extension);
                $this->avatar = '/uploads/' . $this->avatar;
            }
        }
    }

    /**
     * Save categories where user works
     *
     * @param Users $user
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function saveCategories(Users $user): void
    {
        $this->existingSpecializations = Categories::getCategories();
        foreach ($this->specializations ?? [] as $id) {
            if (!UserCategory::findOne(['user_id' => $user->id, 'category_id' => $id])) {
                $this->userCategory = new UserCategory(['category_id' => $id, 'user_id' => $user->id]);
                $this->userCategory->save();
            }
        }

        foreach ($this->existingSpecializations as $id => $name) {
            if (!in_array($id, $this->specializations ?? [])) {
                $this->specializationToBeDeleted = UserCategory::findOne(['user_id' => $user->id, 'category_id' => $id]);

                if ($this->specializationToBeDeleted !== null) {
                    $this->specializationToBeDeleted->delete();
                }
            }
        }
    }

    /**
     * Save common data - password, name, etc.
     * @param Users $user
     * @throws \yii\base\Exception
     */
    private function saveCommonData(Users $user): void
    {
        $user->setScenario(Users::SCENARIO_UPDATE);

        $user->setAttributes($this->attributes);
        $attributesToBeSaved = [];

        if (property_exists($user, 'password')) {
            if ($this->password) {
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $user->save(false, ['password']);
            }
        }

        foreach ($user->attributes as $name => $value) {
            if (!empty($value)) {
                $attributesToBeSaved[] = $name;
            }
        }

        $user->save(false, $attributesToBeSaved);
    }

    /**
     * Check role if user has categories
     * @param Users $user
     */
    private function checkRole(Users $user): void
    {
        if (property_exists($user, 'user_role')) {
            if ($user->userCategories === []) {
                $user->user_role = 'client';
            } else {
                $user->user_role = 'doer';
            }
            $user->save(false, ['user_role']);
        }
    }

    /**
     * Saves user settings
     * @param Users $user
     */
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
}
