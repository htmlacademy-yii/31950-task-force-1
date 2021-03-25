<?php


namespace htmlacademy\service;

use frontend\models\UserTask;

class UpdateUserTask
{
    public function index($userId, $taskId)
    {
        $userTask = new UserTask();
        $userTask->user_id = $userId;
        $userTask->task_id = $taskId;
        $userTask->save();
    }
}
