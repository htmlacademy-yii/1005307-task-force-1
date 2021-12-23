<?php
declare(strict_types=1);

namespace frontend\models\users;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "portfolio_photo".
 *
 * @property int $id
 * @property string $photo
 * @property int $user_id
 *
 * @property Users $user
 */
class PortfolioPhoto extends ActiveRecord
{
    private $photo;
    private $user_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'portfolio_photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id'], 'integer'],
            [['photo'], 'string', 'max' => 255],
            [['photo', 'user_id'], 'required'],
            [['photo', 'user_id'], 'safe'],
            [['user_id'], 'exist',
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
            'photo' => 'Photo',
            'user_id' => 'User ID',
        ];
    }
}
