<?php

use yii\db\Migration;

/**
 * Class m210222_110418_create_table_info
 */
class m210222_110418_create_table_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('info', [
            'id' => $this->primaryKey(),
            'category' => $this->string(),
            'message' => $this->string(),
            'task_id' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->boolean()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-info-task_id',
            'info',
            'task_id'
        );

        $this->addForeignKey(
            'fk-info-task_id',
            'info',
            'task_id',
            'task',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-info-user_id',
            'info',
            'user_id'
        );

        $this->addForeignKey(
            'fk-info-user_id',
            'info',
            'user_id',
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
            'fk-info-task_id',
            'info'
        );

        $this->dropIndex(
            'idx-info-task_id',
            'info'
        );

        $this->dropForeignKey(
            'fk-info-user_id',
            'info'
        );

        $this->dropIndex(
            'idx-info-user_id',
            'info'
        );

        $this->dropTable('info');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210222_110418_create_table_info cannot be reverted.\n";

        return false;
    }
    */
}
