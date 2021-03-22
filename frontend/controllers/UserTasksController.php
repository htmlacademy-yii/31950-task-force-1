<?php


namespace frontend\controllers;


use frontend\models\Task;
use frontend\models\User;

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
        $user = User::findOne($currentUser->id);

        $tasks = Task::find()->joinWith('user')->
        where(['status' => 'complete'])->andWhere([
            'or',
            ['owner_id' => $currentUser->id],
            ['user_task.user_id' => $currentUser->id]
        ])->
        orderBy('date_add DESC')->all();

        return $this->render('completed', compact('tasks', 'user'));
    }

    public function actionActive()
    {
        $currentUser = \Yii::$app->user->identity;
        $user = User::findOne($currentUser->id);

        $tasks = Task::find()->joinWith('user')->
        where(['status' => 'in work'])->andWhere([
            'or',
            ['owner_id' => $currentUser->id],
            ['user_task.user_id' => $currentUser->id]
        ])->
        orderBy('date_add DESC')->all();

        return $this->render('active', compact('tasks', 'user'));
    }

    public function actionFailed()
    {
        $currentUser = \Yii::$app->user->identity;
        $user = User::findOne($currentUser->id);

        $tasks = Task::find()->joinWith('user')->
        where(['status' => 'failed'])->andWhere([
            'or',
            ['owner_id' => $currentUser->id],
            ['user_task.user_id' => $currentUser->id]
        ])->
        orderBy('date_add DESC')->all();

        return $this->render('failed', compact('tasks', 'user'));
    }

    public function actionPast()
    {
        $user = \Yii::$app->user->identity;
        $tasks = Task::find()->where(['status' => 'in work'])->andWhere(['<', 'date_expire', time()])->andWhere(['owner_id' => $user->id])->orderBy('date_add DESC')->all();
        return $this->render('past', compact('tasks', 'user'));
    }
}
