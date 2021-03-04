<?php


namespace frontend\controllers;

use frontend\models\AccountModel;
use frontend\models\Category;
use frontend\models\City;
use frontend\models\Profile;
use frontend\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class AccountController extends SecuredController
{
    public function actionIndex()
    {
        $model = new AccountModel();
        $model->loadDefaultValues();
        $currentUser = \Yii::$app->user->identity;
        $user = User::findOne($currentUser->id);
        if (!is_null($user->profile)) {
            $profileId = $user->profile->id;
            $profile = Profile::findOne($profileId);
        }
        $cities = City::find()->all();
        $cities = ArrayHelper::map($cities, 'id', 'name');
        $categories = Category::find()->indexBy('id')->all();
        $categories = ArrayHelper::map($categories, 'id', 'name');
        $errors = null;
        if ($model->load(Yii::$app->request->post())) {
            if (isset($profile) && $profile->load(Yii::$app->request->post())) {
                if ($profile->validate()) {
                    $profile->save();
                }
            }
            $model->avatar = UploadedFile::getInstance($model, 'avatar');
            $model->file = UploadedFile::getInstances($model, 'file');
            if ($model->validate()) {
                if (!is_dir(Yii::$app->params['userImagesPath'])) {
                    mkdir(Yii::$app->params['userImagesPath'], 0777, true);
                }
                $model->uploadAvatar(Yii::$app->params['userImagesPath']);
                $model->uploadFile(Yii::$app->params['userFilesPath']);
                $model->saveForm();
                return $this->redirect('/account');
            }
        }

        return $this->render('index', compact('model', 'cities', 'user', 'profile', 'categories'));
    }
}
