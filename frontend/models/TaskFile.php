<?php

namespace frontend\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "task_file".
 *
 * @property int $id
 * @property int|null $task_id
 * @property string|null $file
 */
class TaskFile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'file' => 'File',
        ];
    }

    public function saveTaskFile($task, $file)
    {
        $task_file = new TaskFile();
        $task_file->task_id = $task->id;
        $task_file->file = $file->name;
        $task_file->save();
    }
}
