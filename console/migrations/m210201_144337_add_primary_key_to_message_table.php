<?php

use yii\db\Migration;

/**
 * Class m210201_144337_add_primary_key_to_message_table
 */
class m210201_144337_add_primary_key_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createIndex(
            'idx-message-worker_id',
            'message',
            'worker_id'
        );

        $this->addForeignKey(
            'fk-message-worker_id',
            'message',
            'worker_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-message-worker_id',
            'message'
        );

        $this->dropIndex(
            'idx-message-worker_id',
            'message'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210201_144337_add_primary_key_to_message_table cannot be reverted.\n";

        return false;
    }
    */
}
