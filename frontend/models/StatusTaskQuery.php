<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StatusTask]].
 *
 * @see StatusTask
 */
class StatusTaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StatusTask[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StatusTask|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
