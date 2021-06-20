<?php

declare(strict_types=1);

namespace app\models\categories;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\{
    tasks\Tasks,
    users\UserCategory,
    users\Users,
    users\UsersQuery
};

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property string|null $profession
 *
 * @property Tasks[] $tasks
 * @property UserCategory[] $userCategories
 */

class Categories extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
    }

    public function rules()
    {
        return [
            [['name', 'icon'], 'required'],
            [['name', 'icon', 'profession'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['icon'], 'unique'],
            [['profession'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
            'profession' => 'Profession',
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['category_id' => 'id']);
    }

    public function getUserCategory()
    {
        return $this->hasMany(UserCategory::class, ['category_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('user_category', ['categories_id' => 'id']);
    }

    public static function getCategoriesFilters(): array
    {
            $categories = ArrayHelper::map(Categories::getAll(), 'id', 'name');

        return $categories;
    }

    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }

    final public static function getAll()
    {
        return self::find()->asArray()->all();
    }
}
