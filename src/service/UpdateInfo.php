<?php


namespace htmlacademy\service;

use frontend\models\Info;


class UpdateInfo
{
    public function index($id, $category, $message, $user_id)
    {
        $info = new Info();
        $info->category = $category;
        $info->message = $message;
        $info->task_id = $id;
        $info->user_id = $user_id;
        $info->save();
    }
}
