<?php

namespace htmlacademy\helpers;

use frontend\models\Message;
use frontend\models\Task;
use Yii;

/**
 * Класс для работы с действиями заданий
 *
 * Class ActionTaskHelper
 *
 * @package src\ActionTaskHelper
 */
class ActionTaskHelper
{
    /**
     * Добавление нового сообщения к заданию
     *
     * @param Task $task объект задания
     * @param Message $message объект нового сообщения к заданию
     *
     * @return array|null массив с данными нового задания
     */
    public static function message(Task $task, Message $message): ?array
    {
        $newMessage = null;
        $transaction = Yii::$app->db->beginTransaction();
        $newMessage = [
            'message' => $message->message,
            'published_at' => $message->published_at,
            'worker_id' => 2,
            'owner_id' => $message->owner_id,
            'task_id' => $message->task_id,
        ];
        try {
            $message->save();
            $transaction->commit();
        } catch (\Exception $err) {
            $transaction->rollBack();
        }
        return [$newMessage];
    }
}
