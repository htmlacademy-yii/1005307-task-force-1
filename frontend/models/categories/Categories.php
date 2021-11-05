<?php
declare(strict_types=1);

namespace frontend\models\categories;

use frontend\models\{tasks\Tasks, users\UserCategory, users\Users};
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
class Categories extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'categories';
    }

    public function rules(): array
    {
        return [
            [['name', 'icon'], 'required'],
            [['name', 'icon', 'profession'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['icon'], 'unique'],
            [['profession'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
            'profession' => 'Profession',
        ];
    }

    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Tasks::class, ['category_id' => 'id']);
    }

    public function getUserCategory(): ActiveQuery
    {
        return $this->hasMany(UserCategory::class, ['category_id' => 'id']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('user_category', ['categories_id' => 'id']);
    }

    public static function getCategoriesFilters(): array
    {
        return ArrayHelper::map(Categories::getAll(), 'id', 'name');
    }

    public static function find(): CategoriesQuery
    {
        return new CategoriesQuery(get_called_class());
    }

    final public static function getAll(): array
    {
        return self::find()->asArray()->all();
    }
}
