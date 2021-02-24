<?php


namespace frontend\models;

use yii\base\Model;

class TaskCancel extends Model
{
    public $status;
    public $text;
    public $rate;

    public function scenarios()
    {
        return [
            'default' => ['status', 'text', 'rate']
        ];
    }

    public static function tableName()
    {
        return 'task';
    }

    public function saveForm($id)
    {
        $task = Task::findOne($id);
        $task->status = $this->status;
        $task->save();
        if ($this->rate || $this->text) {
            $opinion = new Opinion();
            $opinion->date_add = time();
            $opinion->rate = $this->rate;
            $opinion->description = $this->text;
            $opinion->task_id = $id;
            $opinion->owner_id = \Yii::$app->user->identity->id;
            $opinion->worker_id = UserTask::find()->where(['task_id' => $id])->all()[0]->user_id;
            $opinion->save();

            $info = new Info();
            $info->category = "close";
            $info->message = "Завершение задания";
            $info->task_id = $id;
            $info->user_id = $opinion->worker_id;
            $info->save();
        }
    }
}
