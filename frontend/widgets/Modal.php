<?php


namespace frontend\widgets;


use common\models\LoginForm;
use frontend\models\TaskCancel;
use frontend\models\TaskReject;
use frontend\models\TaskResponse;
use yii\base\Widget;

class Modal extends Widget
{
    public $type;
    public $task;

    public function run()
    {
        $type = $this->type;
        $task = $this->task;

        if ($type === "login") {
            return $this->render("modal/login", ['model' => new LoginForm()]);
        }
        if ($type === "task-reject") {
            return $this->render("modal/task-reject", ['model' => new TaskReject(), 'task' => $task]);
        }
        if ($type === "task-cancel") {
            return $this->render("modal/task-cancel", ['model' => new TaskCancel(), 'task' => $task]);
        }
        if ($type === "task-response") {
            return $this->render("modal/task-response", ['model' => new TaskResponse(), 'task' => $task]);
        }
        return false;
    }
}
