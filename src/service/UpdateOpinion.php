<?php


namespace htmlacademy\service;

use frontend\models\Opinion;
use frontend\models\UserTask;


class UpdateOpinion
{
    public function index($id, $rate, $text)
    {
        $opinion = new Opinion();
        $opinion->date_add = time();
        $opinion->rate = $rate;
        $opinion->description = $text;
        $opinion->task_id = $id;
        $opinion->owner_id = \Yii::$app->user->identity->id;
        $opinion->worker_id = UserTask::find()->where(['task_id' => $id])->all()[0]->user_id;
        $opinion->save();
        return $opinion;
    }
}
