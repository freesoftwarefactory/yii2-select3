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
    public $id = null;  // automatically created on null

    public $model;

    public $attribute;

    public $prompt = "(Choose)";

    public $options = [ "yes" => "Yes" , "no" => "No" ];

    public $allSelectable = true;
    
    public $allSelectableLabel = "(All)";
    
    public $visibleAtStartup = false;

    public function run()
    {
        $this->id = null==$this->id ? $this->getUniqueId() : $this->id;

        $context = Yii::$app->controller;

        Select3Asset::register($context->view);
   
        $markup = $this->getMarkup();

        $hiddenInput = Html::activeHiddenInput($this->model, $this->attribute);

        $values = 
        [
            ":id" => $this->id,

            ":prompt" => htmlentities($this->prompt),

            ":hiddeninput" => $hiddenInput,

            ":options" => $this->renderOptions($this->id, $this->options, 
                    $this->allSelectable, $this->allSelectableLabel),

            ":display" => $this->visibleAtStartup ? "block" : "none",
        ];

        return strtr($markup, $values);
    }

    private function renderOptions($id, $options, $addPrompt, $prompt)
    {
        if(empty($options)) return "";
    
        if(!is_array($options)) return "";

        $payload = "";
    
        $values = $this->getDecodedValue();
        
        $allChecked = true;

        if($values)
        {
            foreach($values as $key=>$value)
                if(!$value)
                {
                    $allChecked = false;
                    break;
                }
        }
        else
        $allChecked = false;


        if(count($options) && $addPrompt)
        {
            $checked = $allChecked ? "checked" : "";

            $payload = "
                <label class='option option-all option-border-color noselect'>
                    <input type='checkbox' data-group='#{$id}' data-type='all' value='' $checked>
                    {$prompt}
                </label>
            ";
        }

        foreach($options as $key=>$value)
        {
            $safeValue = htmlentities($value);

            $checked = $values ? (isset($values[$key]) ? (true==$values[$key]) : false) : false;

            $checked = $checked ? "checked" : "";

            $payload .= "    
                <label class='option option-value option-border-color noselect'>
                    <input type='checkbox' data-group='#{$id}' data-type='value' value='$key' $checked>
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
            <div id=':id' class='select3'>
                <div class='inner'>
                    <div class='select' >
                        <div class='text noselect'>
                            <span class='text-color'>:prompt</span>
                        </div>
                        <div class='activator bg-color'>
                            <div class='caret-down caret-color'></div>
                        </div>
                    </div>
                    <div class='options bg-color-list' group-id='#:id' style='display: :display;'>
                        :options
                    </div>
                </div>
                :hiddeninput
            </div> 
        ";
    }
   
    public static function getDecodedValueFrom($model, $attribute)
    {
        $value = $model->$attribute;

        if(!empty($value))
        {
            return json_decode(base64_decode($value), true);
        }
        else
        {
            return null;
        }
    }
    
    private function getUniqueId()
    {
        return "select3_".hash('crc32',microtime(true));
    }

    private function getDecodedValue()
    {
        return self::getDecodedValueFrom($this->model, $this->attribute);
    }
    
}
