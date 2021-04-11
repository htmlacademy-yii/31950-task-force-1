<?php


namespace frontend\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;


class TasksPagination extends Widget
{
    /**
     * @var ActiveDataProvider
     */
    public $dataProvider;

    public function run()
    {
        $tasks = $this->dataProvider->getModels();

        return $this->render('tasksPagination', compact('tasks'));
    }
}
