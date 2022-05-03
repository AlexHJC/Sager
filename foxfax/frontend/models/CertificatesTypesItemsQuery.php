<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[CertificatesTypesItems]].
 *
 * @see CertificatesTypesItems
 */
class CertificatesTypesItemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CertificatesTypesItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CertificatesTypesItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
