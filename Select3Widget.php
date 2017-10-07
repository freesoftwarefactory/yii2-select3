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

    public $options = [ "yes" => "Yes" , "no" => "No" ];

    public $allSelectable = true;
    
    public $allSelectableLabel = "(All)";

    public function run()
    {
        $context = Yii::$app->controller;

        Select3Asset::register($context->view);
   
        $markup = $this->getMarkup();

        $hiddenInput = Html::activeHiddenInput($this->model, $this->attribute);

        $values = 
        [
            ":prompt" => htmlentities($this->prompt),

            ":hiddeninput" => $hiddenInput,

            ":options" => $this->renderOptions($this->options, 
                    $this->allSelectable, $this->allSelectableLabel),
        ];

        return strtr($markup, $values);
    }

    private function renderOptions($options, $addPrompt, $prompt)
    {
        if(empty($options)) return "";
    
        if(!is_array($options)) return "";

        $payload = "";
    
        if(count($options) && $addPrompt)
        {
            $payload = "
                <label class='option option-all option-border-color noselect'>
                    <input type='checkbox' value='' >
                    {$prompt}
                </label>
            ";
        }

        foreach($options as $key=>$value)
        {
            $safeValue = htmlentities($value);

            $payload .= "    
                <label class='option option-value option-border-color noselect'>
                    <input type='checkbox' value='$key'>
                    {$safeValue}
                </label>
            ";
        }

        return $payload;
    }

    private function getMarkup()
    {
        return 
        "
            <div class='select3'>
                <div class='inner'>
                    <div class='select' >
                        <div class='text noselect'>
                            <span class='text-color'>:prompt</span>
                        </div>
                        <div class='activator bg-color'>
                            <div class='caret-down caret-color'></div>
                        </div>
                    </div>
                    <div class='options' style='_display: none;'>
                        :options
                    </div>
                </div>
                :hiddeninput
            </div> 
        ";
    }

}
