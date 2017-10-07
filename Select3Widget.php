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

    public $prompt = "(Choose)";

    public function run()
    {
        $context = Yii::$app->controller;

        Select3Asset::register($context->view);
   
        $markup = $this->getMarkup();

        return $markup;
    }

    private function getMarkup()
    {
        return 
        "
            <div class='select3'>
                <div class='inner'>
                    <div class='select' >
                        <div class='text'><span class='text-color'>{$this->prompt}</span></div>
                        <div class='activator bg-color'><div class='caret-down caret-color'></div></div>
                    </div>
                </div>
            </div> 
        ";
    }

}
