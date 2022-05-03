<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plan`.
 */
class m171020_205321_create_plan_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%plan}}', [
            'id'               => $this->primaryKey(),
            'plan_slug'        => $this->string(32)->notNull(),
            'plan_title'       => $this->string()->notNull(),
            'plan_price_year'  => $this->double()->null(),
            'plan_price_month' => $this->double()->null(),
            'plan_doc_limit'   => $this->integer(),
            'plan_user_limit'  => $this->integer(),
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%plan}}');
    }
}
