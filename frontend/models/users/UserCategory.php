<?php

namespace app\models\users;

use Yii;
use app\models\{
    categories\Categories
};

/**
 * This is the model class for table "user_category".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 *
 * @property Categories $category
 * @property Users $user
 */
class UserCategory extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_category';
    }

    public function rules()
    {
        return [
            [['user_id', 'category_id'], 'required'],
            [['user_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function find()
    {
        return new UserCategoryQuery(get_called_class());
    }
}
