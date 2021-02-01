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
        $newMessage = [
            'published_at' => $message->published_at,
            'message' => $message->message,
            'worker_id' => $message->worker_id,
            'owner_id' => $message->owner_id,
            'task_id' => $message->task_id,
        ];
        $message->save();
        return [$newMessage];
    }
}
