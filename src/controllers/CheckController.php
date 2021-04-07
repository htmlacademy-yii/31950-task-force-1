<?php


namespace htmlacademy\controllers;

use frontend\models\Response;
use htmlacademy\controllers\Action\WorkAction;
use htmlacademy\controllers\Action\CancelAction;
use htmlacademy\controllers\Action\CompleteAction;


class CheckController
{
    protected $user;
    protected $task;

    public function __construct($user, $task)
    {
        $this->user = $user;
        $this->task = $task;
    }

    public function isShowResponseButton()
    {
        $action = new WorkAction();
        return $action->isRightMethod($this->user, $this->task);
    }

    public function isShowPassButton()
    {
        $action = new CancelAction();
        return $action->isRightMethod($this->user, $this->task);
    }

    public function isShowCompleteButton()
    {
        $action = new CompleteAction();
        return $action->isRightMethod($this->user, $this->task);
    }

    public function isShowActions($response)
    {
        $result = false;
        if ($this->task->response && $this->user->id == $this->task->owner->id) {
            if ($response['status'] !== 'reject' && $this->task->status !== 'in work' && $this->task->status !== 'complete') {
                $result = true;
            }
        }

        return $result;
    }

    public function isShowResponses()
    {
        $result = false;
        $response = Response::find()->where(['user_id' => $this->user->id])->andWhere(['task_id' => $this->task->id])->all();
        if ($this->user->id == $this->task->owner->id || count($response)) {
            $result = true;
        }

        return $result;
    }

    public function isShowResponse($response)
    {
        $result = false;
        if ($this->user->id == $response['user_id'] || $this->user->id == $this->task->owner->id) {
            $result = true;
        }

        return $result;
    }

    public function countResponses()
    {
        if ($this->user->id == $this->task->owner->id) {
            $result = count($this->task->response);
        } else {
            $response = Response::find()->where(['user_id' => $this->user->id])->andWhere(['task_id' => $this->task->id])->all();
            $result = count($response);
        }

        return $result;
    }
}
