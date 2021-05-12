<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property int $id
 * @property string $name
 *
 * @property Users[] $users
 */
class UserRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['user_role_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserRoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserRoleQuery(get_called_class());
    }
}
