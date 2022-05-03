<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Phrases]].
 *
 * @see Phrases
 */
class PhrasesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Phrases[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Phrases|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
