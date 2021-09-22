<?php


namespace soft\base;

use soft\helpers\ArrayHelper;
use soft\helpers\Html;
use yii\base\Widget;

class SoftWidgetBase extends Widget
{

    public $options = [];

    public $tag = 'div';

    public $visible = true;

    public function run()
    {
        if (!$this->visible){
            echo '';
            return ;
        }

        $content = $this->renderWidgetContent();
        $this->options['id'] = $this->getId();
        $tag = ArrayHelper::remove($this->options, 'tag', $this->tag);
        echo Html::tag($tag, $content, $this->options);
    }

    public function renderWidgetContent()
    {
        return "";
    }


}