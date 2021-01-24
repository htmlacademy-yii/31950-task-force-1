<?php

namespace frontend\modules\api\controllers\v1;

use frontend\models\Message;
use yii\rest\ActiveController;
use frontend\models\Task;
use src\ActionTaskHelper\ActionTaskHelper;

class MessagesController extends ActiveController
{
    public $modelClass = Message::class;

    /**
     * Переопределение действий для контроллера
     *
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create']);

        return $actions;
    }

    /**
     * Получени списка сообщений для указанного задания
     *
     * @param int $id идентификатор задания
     *
     * @return array список сообщений
     */
    public function actionIndex(int $id): array
    {
        return $this->modelClass::findAll(['task_id' => $id]);
    }

    /**
     * Добавленние нового сообщения для указанного задания
     *
     * @param int $id идентификатор задания
     *
     * @return array|null данные нового задания
     */
    public function actionCreate(): ?array
    {
        $userId = \Yii::$app->user->identity->id;
        $message = json_decode(\Yii::$app->getRequest()->getRawBody(), true);
        $task = Task::findOne($message['task_id']);

        if (!$message || !$task
            || !$task->getAccessCheckMessageCreate($userId)
        ) {
            return null;
        }

        \Yii::$app->response->statusCode = 201;

        return ActionTaskHelper::message($task, new $this->modelClass([
            'message' => $message['message'],
            'published_at' => date('Y-m-d h:i:s'),
            'owner_id' => $userId,
            'task_id' => $task->id,
        ]));
    }
}
