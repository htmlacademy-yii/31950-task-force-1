<?php


namespace htmlacademy\service;

use frontend\models\Task;

class UpdateTask
{
    public function index($taskId)
    {
        $task = Task::findOne($taskId);
        $task->status = 'in work';
        $task->save();
    }
}
