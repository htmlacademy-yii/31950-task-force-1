<?php


namespace frontend\models;

use htmlacademy\service\UpdateInfo;
use htmlacademy\service\UpdateOpinion;
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
            $opinion = UpdateOpinion::index($id, $this->rate, $this->text);
            UpdateInfo::index($id, "close", "Завершение задания", $opinion->worker_id);
        }
    }
}
