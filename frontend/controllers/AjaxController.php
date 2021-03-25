<?php


namespace frontend\controllers;

use htmlacademy\helpers\Geocoder;
use yii\web\Controller;

class AjaxController extends Controller
{
    // Получает координаты с Api
    public function actionCoords($value)
    {
        $this->layout = false;
        return Geocoder::getCoords($value);
    }
}
