<?php


namespace frontend\models;

use yii\base\Model;

class TaskResponse extends Model
{
    public $status;
    public $price;
    public $text;

    public function scenarios()
    {
        return [
            'default' => ['status', 'price', 'text']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['price', 'trim'],
            ['price', 'required'],
        ];
    }

    public static function tableName()
    {
        return 'task';
    }

    public function saveForm($id)
    {
        $response = new Response();
        $response->price = $this->price;
        $response->description = $this->text;
        $response->date_add = time();
        $response->status = 'new';
        $response->task_id = $id;
        $response->user_id = \Yii::$app->user->identity->id;
        $response->save();
    }
}
