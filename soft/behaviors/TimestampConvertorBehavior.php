<?php

namespace soft\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidArgumentException;
use yii\db\ActiveRecord;

class TimestampConvertorBehavior extends Behavior
{

    /**
     * @var string|array attribute(s) to convert to timestamp
     */
    public $attribute;

    public function init()
    {
        if (empty($this->attribute)) {
            throw new InvalidArgumentException('The "attribute" property must be set!');
        }
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'convertToTimestamp',
        ];
    }

    public function convertToTimestamp()
    {
        $attributes = (array)$this->attribute;
        foreach ($attributes as $attribute) {

            $value = $this->owner->$attribute;
            if (!$this->isTimestamp($value)) {
                $this->owner->$attribute = strtotime($this->owner->$attribute);
            }
        }
    }

    private function isTimestamp($string)
    {
        return (1 === preg_match('~^[1-9][0-9]*$~', $string));
    }
}