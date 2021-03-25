<?php

namespace frontend\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user_task".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $task_id
 *
 * @property Task $task
 * @property User $user
 */
class UserTask extends ActiveRecord
{
    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasMany(Task::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasMany(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }
}
