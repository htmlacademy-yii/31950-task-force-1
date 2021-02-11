<?php

use yii\db\Migration;

/**
 * Class m210211_145614_add_show_my_contacts_to_user_table
 */
class m210211_145614_add_show_my_contacts_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'show_my_contacts', $this->boolean());
        $sql = "UPDATE `user` SET `show_my_contacts` = false";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210211_145614_add_show_my_contacts_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_145614_add_show_my_contacts_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
