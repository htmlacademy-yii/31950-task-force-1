<?php

use yii\db\Migration;

/**
 * Class m210211_141953_update_notification_to_new_message_to_user_table
 */
class m210211_141953_update_notification_to_new_message_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "UPDATE `user` SET `notification_to_new_message` = false";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210211_141953_update_notification_to_new_message_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_141953_update_notification_to_new_message_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
