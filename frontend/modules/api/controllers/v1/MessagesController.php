<?php

namespace frontend\modules\api\controllers\v1;

use frontend\models\Info;
use frontend\models\Message;
use yii\rest\ActiveController;
use frontend\models\Task;
use htmlacademy\helpers\ActionTaskHelper;

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
    public function actionIndex(int $id, int $user_id): array
    {
        return $this->modelClass::find()->andWhere([
            'task_id' => $id
        ])
            ->andWhere([
                'or',
                'worker_id' => $user_id,
                'owner_id' => $user_id
            ])
            ->all();
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
        \Yii::$app->response->statusCode = 201;

        $message = json_decode(\Yii::$app->getRequest()->getRawBody(), true);
        $task = Task::findOne($message['task_id']);
        if (!$message || !$task) {
            return null;
        }
        $user = \Yii::$app->user->identity;

        $info = new Info();
        $info->category = "message";
        $info->message = "Новое сообщение в чате";
        $info->task_id = $task->id;
        if ($user->id == $message["owner_id"]) {
            $info->user_id = $message["worker_id"];
        } else {
            $info->user_id = $message["owner_id"];
        }
        $info->save();

        return ActionTaskHelper::message($task, new $this->modelClass([
            'published_at' => time(),
            'message' => $message["message"],
            'owner_id' => $message["owner_id"],
            'task_id' => $task->id,
            'worker_id' => $message["worker_id"],
        ]));
    }
}
