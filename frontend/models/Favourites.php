<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%favourites}}".
 *
 * @property int $id
 * @property string $dt_add
 * @property string|null $type_favourite
 * @property int $user_id
 * @property int $favourite_person_id
 *
 * @property Users $favouritePerson
 * @property Users $user
 */
class Favourites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%favourites}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['user_id', 'favourite_person_id'], 'required'],
            [['user_id', 'favourite_person_id'], 'integer'],
            [['type_favourite'], 'string', 'max' => 128],
            [['favourite_person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['favourite_person_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'type_favourite' => 'Type Favourite',
            'user_id' => 'User ID',
            'favourite_person_id' => 'Favourite Person ID',
        ];
    }

    /**
     * Gets query for [[FavouritePerson]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavouritePerson()
    {
        return $this->hasOne(Users::className(), ['id' => 'favourite_person_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
