<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Ассет для страницы аккаунта
 *
 * Class AccountAsset
 *
 * @package frontend\assets
 */
class AccountAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
            'js/dropzone.js',
            'js/initAccountDropzone.js',
        ];
}
