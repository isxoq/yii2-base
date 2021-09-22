<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

namespace soft\widget\kartik;


use soft\helpers\ArrayHelper;
use yii\base\InvalidArgumentException;
use yii\helpers\Html;

class DatePicker extends \kartik\widgets\DatePicker
{

    public $dateFormat = 'd.m.Y';

    public $placeholder = 'KK-MM-YYYY';

    public $autoclose = true;
    public $todayHighlight = true;

    public $language = 'ru';

    public function run()
    {
        parent::run();
    }

    public function init()
    {
        parent::init();

        $this->normalizeValues();

        $this->normalizeAttributes();

        if (!isset($this->options['placeholder'])) {
            $this->options['placeholder'] = 'KK.OO.YYYY';
        }
        if (!isset($this->pluginOptions['autoclose'])) {
            $this->pluginOptions['autoclose'] = true;
        }

        $this->registerCss();

    }

    private function normalizeValues()
    {
        if ($this->hasModel()) {
            $value = $this->value;
            if (!empty($value) && is_integer($value)) {

                if (!preg_match(Html::$attributeRegex, $this->attribute, $matches)) {
                    throw new InvalidArgumentException('Attribute name must contain word characters only.');
                }
                $attribute = $matches[2];
                $this->value = date($this->dateFormat, $value);
                $this->model->$attribute = date($this->dateFormat, $value);
            }
        } else {

            $value = $this->value;
            if (!empty($value) && is_integer($value)) {
                $this->value = date($this->dateFormat, $value);
            }

        }

    }

    private function registerCss()
    {
        $css = <<<CSS
        .datepicker-dropdown{
            z-index: 9999!important;
        }
CSS;

        $this->view->registerCss($css, [], 'datepicker-dropdown-css');
    }

    private function defaultPluginOptions()
    {
        return [
            'autoclose' => $this->autoclose,
            'todayHighlight' => $this->todayHighlight,
        ];
    }
    private function defaultOptions()
    {
        return [
            'placeholder' => $this->placeholder,
        ];
    }

    private function normalizeAttributes()
    {
        $this->pluginOptions = ArrayHelper::merge($this->pluginOptions, $this->defaultPluginOptions());
        $this->options = ArrayHelper::merge($this->options, $this->defaultOptions());
    }
}