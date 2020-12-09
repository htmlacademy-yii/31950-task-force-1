<?php

namespace frontend\controllers;

use frontend\models\Response;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use frontend\models\Category;
use frontend\models\TaskModel;
use frontend\models\Task;
use frontend\models\User;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $categories = Category::find()->indexBy('id')->all();
        $allTasks = Task::find()->orderBy('date_add DESC');
        $model = new TaskModel();
        if (\Yii::$app->request->get('TaskModel', false) !== false) {
            $model->load(\Yii::$app->request->get());
        }

        $tasks = $model->applyFilters($allTasks)->all();

        return $this->render('index', compact('tasks', 'categories', 'model'));
    }

    public function actionView($id)
    {
        $task = Task::findOne($id);

        if (!$task) {
            throw new NotFoundHttpException("Задача с ID $id не найдена");
        }

        return $this->render('view', compact('task'));
    }
}