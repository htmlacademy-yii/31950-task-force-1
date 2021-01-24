<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $published_at
 * @property string $message
 * @property int $worker_id
 * @property int $owner_id
 * @property int $task_id
 *
 * @property User $owner
 * @property Profile $worker
 * @property Task $task
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    public function scenarios()
    {
        return [
            'default' => ['published_at', 'message', 'worker_id', 'owner_id', 'task_id']
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'published_at' => 'Published At',
            'message' => 'message',
            'worker_id' => 'Worker ID',
            'owner_id' => 'Owner ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[Worker]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorker()
    {
        return $this->hasOne(Profile::className(), ['id' => 'worker_id']);
    }
}
