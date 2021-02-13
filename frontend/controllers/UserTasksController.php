<?php


namespace frontend\controllers;


use frontend\models\Task;
use frontend\models\User;
use frontend\models\UserTask;

class UserTasksController extends SecuredController
{
    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;
        $tasks = Task::find()->where(['status' => 'new'])->andWhere(['owner_id' => $user->id])->orderBy('date_add DESC')->all();
        return $this->render('index', compact('tasks', 'user'));
    }

    public function actionCompleted()
    {
        $currentUser = \Yii::$app->user->identity;
        $ownerTasks = Task::find()->where(['status' => 'complete'])->andWhere(['owner_id' => $currentUser->id])->orderBy('date_add DESC')->all();

        $user = User::findOne($currentUser->id);
        $userTasks = $user->tasks;

        $completedUserTasks = [];
        foreach ($userTasks as $userTask) {
            if ($userTask->status == "complete") {
                $completedUserTasks[0] = $userTask;
            }
        }
        $commonTasks = array_merge($ownerTasks, $completedUserTasks);
        $tasks = $this->customMultiSort($commonTasks, "date_add");

        return $this->render('completed', compact('tasks', 'user'));
    }

    public function actionActive()
    {
        $currentUser = \Yii::$app->user->identity;

        $ownerTasks = Task::find()->
        where(['status' => 'in work'])->
        andWhere(['owner_id' => $currentUser->id])->
        orderBy('date_add DESC')->all();

        $user = User::findOne($currentUser->id);

        $userTasks = $user->tasks;
        $activeUserTasks = [];
        foreach ($userTasks as $userTask) {
            if ($userTask->status == "in work") {
                $activeUserTasks[0] = $userTask;
            }
        }

        $commonTasks = array_merge($ownerTasks, $activeUserTasks);

        $tasks = $this->customMultiSort($commonTasks, "date_add");

        return $this->render('active', compact('tasks', 'user'));
    }

    public function actionFailed()
    {
        $currentUser = \Yii::$app->user->identity;
        $ownerTasks = Task::find()->
        where(['status' => 'failed'])->
        andWhere(['owner_id' => $currentUser->id])->orderBy('date_add DESC')->
        all();
        $user = User::findOne($currentUser->id);

        $userTasks = $user->tasks;
        $failedUserTasks = [];
        foreach ($userTasks as $userTask) {
            if ($userTask->status == "failed") {
                $failedUserTasks[0] = $userTask;
            }
        }

        $commonTasks = array_merge($ownerTasks, $failedUserTasks);

        $tasks = $this->customMultiSort($commonTasks, "date_add");
        return $this->render('failed', compact('tasks', 'user'));
    }

    public function actionPast()
    {
        $user = \Yii::$app->user->identity;
        $tasks = Task::find()->where(['status' => 'in work'])->andWhere(['<', 'date_expire', time()])->andWhere(['owner_id' => $user->id])->orderBy('date_add DESC')->all();
        return $this->render('past', compact('tasks', 'user'));
    }

    public function customMultiSort($array, $field)
    {
        $sortArr = array();
        foreach ($array as $key => $val) {
            $sortArr[$key] = $val[$field];
        }

        array_multisort($sortArr, $array);

        return $array;
    }
}
