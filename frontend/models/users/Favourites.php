<?php

namespace frontend\models\users;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "favourites".
 *
 * @property int $id
 * @property string $dt_add
 * @property int $favourite_person_id
 * @property int $user_id
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
            [['favourite_person_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['favourite_person_id' => 'id']],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'favourite_person_id' => 'Favourite Person ID',
            'user_id' => 'User ID',
        ];
    }
}
