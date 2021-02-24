<?php

use yii\db\Migration;

/**
 * Class m210211_145251_add_notification_to_new_review_to_user_table
 */
class m210211_145251_add_notification_to_new_review_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'notification_to_new_review', $this->boolean());
        $sql = "UPDATE `user` SET `notification_to_new_review` = false";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'notification_to_new_review');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_145251_add_notification_to_new_review_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
