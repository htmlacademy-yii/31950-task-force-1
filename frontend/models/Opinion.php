<?php

namespace frontend\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "opinion".
 *
 * @property int $id
 * @property string $date_add
 * @property int $rate
 * @property string $description
 * @property int $owner_id
 * @property int $worker_id
 * @property int $task_id
 *
 * @property User $owner
 * @property Profile $worker
 */
class Opinion extends ActiveRecord
{
    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[Worker]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorker()
    {
        return $this->hasOne(Profile::class, ['id' => 'worker_id']);
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

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opinion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_add', 'owner_id', 'worker_id'], 'required'],
            [['date_add'], 'safe'],
            [['rate', 'owner_id', 'worker_id', 'task_id'], 'integer'],
            [['description'], 'string'],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['worker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['worker_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_add' => 'Date Add',
            'rate' => 'Rate',
            'description' => 'Description',
            'owner_id' => 'Owner ID',
            'worker_id' => 'Worker ID',
            'task_id' => 'Task ID',
        ];
    }
}
