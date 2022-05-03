<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Settings]].
 *
 * @see Settings
 */
class SettingsQuery extends \yii\db\ActiveQuery
{

    /**
     * @inheritdoc
     * @return Settings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Settings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
