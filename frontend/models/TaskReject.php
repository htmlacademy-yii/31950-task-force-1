<?php


namespace frontend\models;

use htmlacademy\service\UpdateInfo;
use htmlacademy\service\UpdateUser;
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

        $updateUser = new UpdateUser();
        $updateUser->index();

        $updateInfo = new UpdateInfo();
        $updateInfo->index($id, "close", "Отказ от задания исполнителем", $task->owner_id);
    }
}
