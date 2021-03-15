<?php

namespace frontend\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "info".
 *
 * @property int $id
 * @property string $category
 * @property string $message
 * @property int $task_id
 * @property int $user_id
 * @property boolean $status
 */
class Info extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info';
    }

    public function scenarios()
    {
        return [
            'default' => ['status', 'task_id', 'user_id', 'message', 'category']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id','user_id'], 'integer'],
            [['status'], 'boolean'],
            [['category', 'message'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'message' => 'Message',
            'task_id' => 'Task ID',
            'status' => 'Status',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }
}
