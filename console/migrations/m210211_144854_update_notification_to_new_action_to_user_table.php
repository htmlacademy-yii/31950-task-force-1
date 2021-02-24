<?php

use yii\db\Migration;

/**
 * Class m210211_144854_update_notification_to_new_action_to_user_table
 */
class m210211_144854_update_notification_to_new_action_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "UPDATE `user` SET `notification_to_new_action` = false";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210211_144854_update_notification_to_new_action_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_144854_update_notification_to_new_action_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
