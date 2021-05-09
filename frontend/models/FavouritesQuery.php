<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Favourites]].
 *
 * @see Favourites
 */
class FavouritesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Favourites[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Favourites|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
