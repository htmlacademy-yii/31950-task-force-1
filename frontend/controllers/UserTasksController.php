<?php


namespace frontend\controllers;


use frontend\models\Task;

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
        $user = \Yii::$app->user->identity;
        $tasks = Task::find()->where(['status' => 'complete'])->andWhere(['owner_id' => $user->id])->orderBy('date_add DESC')->all();
        return $this->render('completed', compact('tasks', 'user'));
    }

    public function actionActive()
    {
        $user = \Yii::$app->user->identity;
        $tasks = Task::find()->
        where(['status' => 'in work'])->
        andWhere(['owner_id' => $user->id])->
        orderBy('date_add DESC')->all();
        return $this->render('active', compact('tasks', 'user'));
    }

    public function actionFailed()
    {
        $user = \Yii::$app->user->identity;
        $tasks = Task::find()->
        where(['status' => 'failed'])->
        andWhere(['owner_id' => $user->id])->orderBy('date_add DESC')->
        all();
        return $this->render('failed', compact('tasks', 'user'));
    }

    public function actionPast()
    {
        $user = \Yii::$app->user->identity;
        $tasks = Task::find()->where(['status' => 'in work'])->andWhere(['<', 'date_expire', time()])->andWhere(['owner_id' => $user->id])->orderBy('date_add DESC')->all();
        return $this->render('past', compact('tasks', 'user'));
    }
}
