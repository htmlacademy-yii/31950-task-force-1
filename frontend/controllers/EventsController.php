<?php


namespace frontend\controllers;


use frontend\models\Info;
use frontend\models\Task;

class EventsController extends SecuredController
{
    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $currentUser = \Yii::$app->user->identity;
        $info = Info::find()->where(['status' => 1])->andWhere(['user_id' => $currentUser->id])->all();
        $tasks = Task::find()->all();
        $infoChange = Info::find()->where(['status' => 1])->andWhere(['user_id' => $currentUser->id])->all();
        foreach ($infoChange as $item) {
            $item->status = 0;
            $item->save();
        }
        return ['info' => $info, 'tasks' => $tasks];
    }
}
