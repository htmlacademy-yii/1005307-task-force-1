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
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'favourites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['favourite_person_id', 'user_id'], 'integer'],
            [['dt_add'], 'string'],
            [['dt_add', 'favourite_person_id', 'user_id'], 'required'],
            [['dt_add', 'favourite_person_id', 'user_id'], 'safe'],
            ['favourite_person_id', 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['favourite_person_id' => 'id']],
            ['user_id', 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
