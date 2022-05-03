<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Labels]].
 *
 * @see Labels
 */
class LabelsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Labels[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Labels|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
