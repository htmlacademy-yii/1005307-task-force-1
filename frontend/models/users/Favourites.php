<?php

namespace frontend\models\users;

use Yii;

/**
 * This is the model class for table "favourites".
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

    public static function tableName()
    {
        return 'favourites';
    }

    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['user_id', 'favourite_person_id'], 'required'],
            [['user_id', 'favourite_person_id'], 'integer'],
            [['type_favourite'], 'string', 'max' => 255],
            [['favourite_person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['favourite_person_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

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

    public function getFavouritePerson()
    {
        return $this->hasOne(Users::class, ['id' => 'favourite_person_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function find()
    {
        return new FavouritesQuery(get_called_class());
    }
}
