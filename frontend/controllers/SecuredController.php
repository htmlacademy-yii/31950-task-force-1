<?php

namespace frontend\controllers;

use frontend\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;

abstract class SecuredController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            return $action->controller->redirect('/');
                        },
                    ],
                ]
            ]
        ];
    }

    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        $currentUser = \Yii::$app->user->identity;
        if ($currentUser) {
            $user = User::findOne($currentUser->id);
            $user->date_last = time();
            $user->save();
        }

        return true;
    }
}
