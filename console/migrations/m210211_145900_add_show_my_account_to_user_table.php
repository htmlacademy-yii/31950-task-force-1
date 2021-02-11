<?php

use yii\db\Migration;

/**
 * Class m210211_145900_add_show_my_account_to_user_table
 */
class m210211_145900_add_show_my_account_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'show_my_account', $this->boolean());
        $sql = "UPDATE `user` SET `show_my_account` = false";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210211_145900_add_show_my_account_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_145900_add_show_my_account_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
