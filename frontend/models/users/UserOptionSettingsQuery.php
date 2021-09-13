<?php

namespace frontend\models\users;

/**
 * This is the ActiveQuery class for [[UsersOptionalSettings]].
 *
 * @see UsersOptionalSettings
 */
class UserOptionSettingsQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return UserOptionSettings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserOptionSettings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
