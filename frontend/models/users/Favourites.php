<?php

namespace frontend\models\users;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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

class Favourites extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'favourites';
    }

    public function rules(): array
    {
        return [
            [['dt_add'], 'safe'],
            [['user_id', 'favourite_person_id'], 'required'],
            [['user_id', 'favourite_person_id'], 'integer'],
            [['type_favourite'], 'string', 'max' => 255],
            [['favourite_person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['favourite_person_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'type_favourite' => 'Type Favourite',
            'user_id' => 'User ID',
            'favourite_person_id' => 'Favourite Person ID',
        ];
    }

    public function getFavouritePerson(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'favourite_person_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function find(): FavouritesQuery
    {
        return new FavouritesQuery(get_called_class());
    }
}
