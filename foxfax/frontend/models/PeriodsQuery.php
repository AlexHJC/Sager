<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Periods]].
 *
 * @see Periods
 */
class PeriodsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Periods[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Periods|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
