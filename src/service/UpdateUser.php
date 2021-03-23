<?php


namespace htmlacademy\service;

use frontend\models\Profile;
use frontend\models\User;

class UpdateUser
{
    public static function index(){
        $user_id = \Yii::$app->user->identity->id;

        $user = User::findOne($user_id);
        $profile_id = $user->profile->id;
        $profile = Profile::findOne($profile_id);
        $profile->popular = $profile->popular - 1;

        $profile->save();
    }
}
