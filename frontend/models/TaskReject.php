<?php


namespace frontend\models;

use yii\base\Model;

class TaskReject extends Model
{
    public $status;

    public function scenarios()
    {
        return [
            'default' => ['status']
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

        $user_id = \Yii::$app->user->identity->id;
        $user = User::findOne($user_id);
        $profile_id = $user->profile->id;
        $profile = Profile::findOne($profile_id);
        $profile->popular = $profile->popular - 1;

        $profile->save();

        $info = new Info();
        $info->category = "close";
        $info->message = "Отказ от задания исполнителем";
        $info->task_id = $id;
        $info->user_id = $task->owner_id;
        $info->save();

    }
}
