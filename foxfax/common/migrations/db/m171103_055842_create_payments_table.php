<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payments`.
 */
class m171103_055842_create_payments_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%payments}}', [
            'id'                 => $this->primaryKey(),
            'user_id'            => $this->integer()->notNull(),
            'plan_id'            => $this->integer()->notNull(),
            'payment_cycle'      => $this->string(12)->notNull()->defaultValue('month'),
            'payer_id'           => $this->string(40)->null(),
            'payment_id'         => $this->string(255)->notNull(),
            'payment_state'      => $this->string(20)->notNull(),
            'payment_amount'     => $this->double()->null(),
            'payment_currency'   => $this->char(3)->null(),
            'payment_method'     => $this->string()->notNull(),
            'invoice_number'     => $this->string(20),
            'status'             => $this->string(20),
            'payer_email'        => $this->string(60),
            'payer_first_name'   => $this->string(40),
            'payer_last_name'    => $this->string(40),
            'payer_phone'        => $this->string(40),
            'payer_country_code' => $this->char(2),
            'plan_user_limit'    => $this->integer(),
        ]);

        $this->addForeignKey('fk_payments_user_id',
            '{{%payments}}',
            'user_id',
            '{{%user}}',
            'id',
            'cascade',
            'cascade');

        $this->addForeignKey('fk_payments_plan_id',
            '{{%payments}}',
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
        $this->dropForeignKey('fk_payments_user_id', '{{%payments}}');
        $this->dropTable('{{%payments}}');
    }
}
