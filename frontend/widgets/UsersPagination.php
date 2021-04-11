<?php


namespace frontend\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;


class UsersPagination extends Widget
{
    /**
     * @var ActiveDataProvider
     */
    public $dataProvider;

    public function run()
    {
        $users = $this->dataProvider->getModels();

        return $this->render('usersPagination', compact('users'));
    }
}
