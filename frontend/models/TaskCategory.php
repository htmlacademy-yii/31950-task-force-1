<?php

namespace frontend\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "task_category".
 *
 * @property int $id
 * @property int $task_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Task $task
 */
class TaskCategory extends ActiveRecord
{
    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id']);
    }

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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_category';
    }

    public function scenarios()
    {
        return [
            'default' => ["task", 'category']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'category_id'], 'required'],
            [['task_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
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
            'category_id' => 'Category ID',
        ];
    }

    public function saveTaskCategory($task, $category_id)
    {
        $task_category = new TaskCategory();
        $task_category->task_id = $task->id;
        $task_category->category_id = $category_id;
        $task_category->save();
    }
}
