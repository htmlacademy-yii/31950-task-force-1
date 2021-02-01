<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%message}}`.
 */
class m210123_054121_add_task_id_column_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('message', 'task_id', $this->integer());
        $this->addForeignKey(
            'fk-task-task_id',
            'message',
            'task_id',
            'task',
            'id',
            'CASCADE'
        );
        $sql = "UPDATE `message` SET `task_id` = '1'";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
