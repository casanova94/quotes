<?php

use yii\db\Migration;

/**
 * Class m240000_000000_add_user_id_to_technicians
 */
class m240000_000000_add_user_id_to_technicians extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%technicians}}', 'user_id', $this->integer()->null()->after('email'));
        $this->addForeignKey(
            'fk-technicians-user_id',
            '{{%technicians}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-technicians-user_id', '{{%technicians}}');
        $this->dropColumn('{{%technicians}}', 'user_id');
    }
} 