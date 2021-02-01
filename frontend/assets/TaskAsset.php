<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Ассет для страницы задания
 *
 * Class TaskAsset
 *
 * @package frontend\assets
 */
class TaskAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
            'js/messenger.js',
        ];
}
