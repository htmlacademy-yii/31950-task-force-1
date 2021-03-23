<?php


namespace frontend\models;

use htmlacademy\service\UpdateResponse;
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
        UpdateResponse::index($id, $this->price, $this->text);
    }
}
