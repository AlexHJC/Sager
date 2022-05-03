<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subscription`.
 */
class m171020_212945_create_subscription_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%subscription}}', [
            'id'           => $this->primaryKey(),
            'user_id'      => $this->integer()->notNull(),
            'plan_id'      => $this->integer()->notNull(),
            'plan_cycle'   => $this->string(12)->notNull()->defaultValue('month'),
            'purchased_at' => $this->integer()->notNull(),
            'start_at'     => $this->integer(),
            'end_at'       => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_subscription_user_id',
            '{{%subscription}}',
            'user_id',
            '{{%user}}',
            'id',
            'cascade',
            'cascade');
        $this->addForeignKey('fk_subscription_plan_id',
            '{{%subscription}}',
            'plan_id',
            '{{%plan}}',
            'id',
            'cascade',
            'cascade');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_subscription_plan_id', '{{%subscription}}');
        $this->dropForeignKey('fk_subscription_user_id', '{{%subscription}}');
        $this->dropTable('{{%subscription}}');
    }
}
