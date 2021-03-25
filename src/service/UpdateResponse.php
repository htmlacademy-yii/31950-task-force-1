<?php


namespace htmlacademy\service;

use frontend\models\Response;

class UpdateResponse
{
    public function index($id, $price, $text)
    {
        $response = new Response();
        $response->price = $price;
        $response->description = $text;
        $response->date_add = time();
        $response->status = 'new';
        $response->task_id = $id;
        $response->user_id = \Yii::$app->user->identity->id;
        $response->save();
    }
}
