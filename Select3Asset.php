<?php
namespace freesoftwarefactory\select3;

use yii\web\AssetBundle;

class Select3Asset extends AssetBundle
{
    public $sourcePath = '@vendor/freesoftwarefactory/select3/assets';
    public $js = [
        'select3.js',
    ];
    public $css = [
        'select3.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
