<?php

namespace frontend\controllers;

use frontend\models\Info;
use frontend\models\TaskCancel;
use frontend\models\TaskReject;
use frontend\models\TaskResponse;
use htmlacademy\service\UpdateInfo;
use htmlacademy\service\UpdateTask;
use htmlacademy\service\UpdateUserTask;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use frontend\models\Category;
use frontend\models\TaskModel;
use frontend\models\Task;
use frontend\models\TaskForm;
use frontend\models\Response;
use htmlacademy\controllers\CheckController;

class TasksController extends SecuredController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'matchCallback' => function () {
                return Yii::$app->user->identity->role !== "owner";
            }
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionIndex()
    {
        $categories = Category::find()->indexBy('id')->all();
        $allTasks = Task::find()->where(['<>', 'status', 'in work'])->andWhere(['<>', 'status', 'complete'])->orderBy('date_add DESC');
        $model = new TaskModel();
        if (\Yii::$app->request->get('TaskModel', false) !== false) {
            $model->load(\Yii::$app->request->get());
        }

        $tasks = $model->applyFilters($allTasks);
        $pages = new Pagination(['totalCount' => $tasks->count(), 'pageSize' => 5]);
        $tasks = $tasks->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', compact('tasks', 'pages', 'categories', 'model'));
    }

    public function actionView($id)
    {
        $task = Task::findOne($id);

        if (!$task) {
            throw new NotFoundHttpException("Задача с ID $id не найдена");
        }
        $user = \Yii::$app->user->identity;
        $check = new CheckController($user, $task);

        return $this->render('view', compact('task', 'check'));
    }

    public function actionCreate()
    {
        $model = Yii::$container->get(TaskForm::class);
        $categories = Category::find()->indexBy('id')->all();
        $categories = ArrayHelper::map($categories, 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstances($model, 'file');

            if ($model->validate()) {
                if (!is_dir(Yii::$app->params['taskImagesPath'])) {
                    mkdir(Yii::$app->params['taskImagesPath'], 0777, true);
                }
                $model->upload(Yii::$app->params['taskImagesPath']);
                $model->saveForm();
                return $this->redirect('/tasks');
            }
        }

        $errors = $model->getErrors();
        return $this->render('create', compact("model", 'categories', 'errors'));
    }

    // Отклоняет задачу
    public function actionReject($id)
    {
        $model = new TaskReject();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->saveForm($id);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    // Завершает задачу
    public function actionCancel($id)
    {
        $model = new TaskCancel();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->saveForm($id);
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    //Отклик на задачу
    public function actionResponse($id)
    {
        $model = new TaskResponse();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->saveForm($id);
            }
        }
        $task = Task::findOne($id);

        $info = new Info();
        $info->category = "message";
        $info->message = "Новый отклик к заданию";
        $info->task_id = $id;
        $info->user_id = $task->owner_id;
        $info->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    // Отклоняет завку
    public function actionResponseReject($id)
    {
        $response = Response::findOne($id);
        $response->status = 'reject';
        $response->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    // Принимает заявку
    public function actionResponseApply($taskId, $responseId, $userId)
    {
        $response = Response::findOne($responseId);
        $response->status = 'apply';
        $response->save();

        $updateUserTask = new UpdateUserTask();
        $updateUserTask->index($userId, $taskId);

        $updateTask = new UpdateTask();
        $updateTask->index($taskId);

        $updateInfo = new UpdateInfo();
        $updateInfo->index($taskId, "executor", "Старт задания", $userId);

        return $this->redirect(Yii::$app->request->referrer);
    }
}
