<?php

use yii\db\Migration;

/**
 * Class m210211_144808_add_notification_to_new_action_to_user_table
 */
class m210211_144808_add_notification_to_new_action_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'notification_to_new_action', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'notification_to_new_action');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_144808_add_notification_to_new_action_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
