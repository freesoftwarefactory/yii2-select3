<?php
namespace freesoftwarefactory\select3;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use freesoftwarefactory\select3\Select3Asset;

/**
 * Select3Widget 
 * 
 * @uses Widget
 * Cristian Salazar <proyectos@chileshift.cl> 
 * Company:chileshift.cl
 */
class Select3Widget extends Widget
{
    public $model;

    public $attribute;

    public function run()
    {
        $context = Yii::$app->controller;

        Select3Asset::register($context->view);
    }
}
