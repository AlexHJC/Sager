<?php

use yii\db\Migration;

/**
 * Class m181008_190609_label
 */
class m181008_190609_label extends Migration
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

         $this->createTable('{{%labels}}', [
            'id'            => $this->primaryKet(),
            'title'         => $this->string(255);
            'color'         => $this->string(20);
            'status'        => $this->string(20);
            'position'      => $this->integer(),
            'account_id'    => $this->integer() . ' UNSIGNED'

         ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('{{%labels}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181008_190609_label cannot be reverted.\n";

        return false;
    }
    */
}
