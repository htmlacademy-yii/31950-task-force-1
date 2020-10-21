<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->orderBy('date_add DESC')->all();

        return $this->render('index', compact('tasks'));
    }
}
