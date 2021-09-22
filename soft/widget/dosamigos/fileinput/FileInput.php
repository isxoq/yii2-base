<?php

namespace soft\widget\dosamigos\fileinput;

use soft\helpers\Html;

class FileInput extends \dosamigos\fileinput\FileInput
{


    public $style = self::STYLE_CUSTOM;

    public $onlyImage = false;

    public $imgUrl;

    public function init()
    {

        if ($this->onlyImage){
            $this->options['accept'] = 'image/*';
        }

        if ($this->style == self::STYLE_CUSTOM && $this->customView == null){
            $this->customView = $this->getViewPath(). "/imageFieldBs4.php";
        }

        if ($this->thumbnail == null){
            $imgUrl = $this->imgUrl ?? $this->model->{$this->attribute};
            if ($this->imgUrl != null){
                $this->thumbnail = Html::img($imgUrl, ['style' => ['max-height' => '200px']]);
            }
        }

        parent::init();
    }


}