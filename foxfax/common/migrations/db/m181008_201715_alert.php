<?php

use yii\db\Migration;

/**
 * Class m181008_201715_alert
 */
class m181008_201715_alert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%alerts}}', [
            'id'                => $this->primaryKey(),
            'title_en'          => $this->string(255),
            'title_fr'          => $this->string(255),
            'certificate_id'    => $this->integer() . ' UNSIGNED ',
            'label_id'          => $this->integer() . ' UNSIGNED ',
            'notification_id'   => $this->integer() . ' UNSIGNED ',
            'period_id'         => $this->integer() . ' UNSIGNED ',
            'position'          => $this->integer() . ' UNSIGNED ',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181008_201715_alert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181008_201715_alert cannot be reverted.\n";

        return false;
    }
    */
}
