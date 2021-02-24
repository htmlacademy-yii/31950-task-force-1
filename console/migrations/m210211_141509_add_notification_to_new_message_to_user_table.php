<?php

use yii\db\Migration;

/**
 * Class m210211_141509_add_notification_to_new_message_to_user_table
 */
class m210211_141509_add_notification_to_new_message_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'notification_to_new_message', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'notification_to_new_message');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_141509_add_notification_to_new_message_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
