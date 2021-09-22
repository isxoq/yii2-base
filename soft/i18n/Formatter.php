<?php

namespace soft\i18n;

use yii\i18n\Formatter as YiiFormatter;
use soft\helpers\Html;
use Yii;

class Formatter extends YiiFormatter
{


    public $nullDisplay = '<i class="text-danger">null</i>';

    public function asStatus($value)
    {
        switch ($value) {
            case 1:
            case 10:
                return '<span class="badge badge-success">' . Yii::t('site', 'Active') . '</span>';
            case 0:
                return '<span class="badge badge-danger">' . Yii::t('site', 'Inactive') . '</span>';
            case 2:
                return '<span class="badge badge-warning">' . Yii::t('site', 'Archived') . '</span>';
            default:
                return $value;
        }
    }

    public function asDollar($value)
    {
        return $this->asDecimal($value, 1) . "$";
    }

    public function asSum($value)
    {
        if ($value == null) {
            return "";
        }
        return $this->asInteger($value) . " " . Yii::t('site', "sum");
    }

    public function asLittleImage($value, $width = '150px')
    {
        $options['width'] = $width;
        return $this->asImage($value, $options);
    }

    /**
     * @throws \Exception
     */
    public function asThumbnail($value = null, $size = '75px', $options = [])
    {
        $class = isBs4() ? "img-thumbnail" : 'thumbnail';
        if ($value == null) {
            return $this->nullDisplay;
        }
        Html::addCssClass($options, $class);
        Html::addCssStyle($options, "max-height:{$size};max-width:{$size};display: block;margin-left: auto;margin-right: auto;");
        return Html::img($value, $options);

    }

    public function asBool($value, $text1 = null, $text2 = null)
    {
        if ($text1 == null) {
            $text1 = t('Yes', 'yii');
        }
        if ($text2 == null) {
            $text2 = t('No', 'yii');
        }
        if ($value) {
            return Html::tag('span', $text1, ['class' => 'badge badge-primary']);
        } else {
            return Html::tag('span', $text2, ['class' => 'badge badge-danger']);
        }
    }

    public function asShortText($value, $length = 150, $end = " ...")
    {
        $text = strip_tags($value);
        if (strlen($text) < $length) {
            return $text;
        }
        return mb_substr(strip_tags($text), 0, $length) . $end;
    }

    /**
     * @param $value int timestapm
     * @return string|null
     */
    public function asDateUz($value = null)
    {
        if ($value == null) {
            return null;
        }
        $month = Yii::t('site', date('M', $value));

        return date('d', $value) . "-" . $month . "-" . date('Y', $value);
    }

    /**
     * @param $value integer
     * @return string|null
     */
    public function asFullDateUz($value = null)
    {
        if ($value == null) {
            return null;
        }
        $month = $this->fullMonthName(date('F', $value));
        return date('d', $value) . "-" . $month . "-" . date('Y', $value);
    }

    /**
     * @param $value integer
     * @return false|string|null
     */
    public function asTimeUz($value = null)
    {
        if ($value == null) {
            return null;
        }

        return date('H:i', $value);
    }

    /**
     * @param $value integer
     * @return string|null Formatted datetime
     */
    public function asDateTimeUz($value = null)
    {
        if ($value == null) {
            return null;
        }

        return $this->asDateUz($value) . " " . $this->asTimeUz($value);
    }

    /**
     * @param $value integer
     * @return string|null
     */
    public function asFullDateTimeUz($value = null)
    {
        if ($value == null) {
            return null;
        }

        return $this->asFullDateUz($value) . " " . $this->asTimeUz($value);
    }

    /**
     * @param string $value phone number, like "+998911234567", or "911234567", or "998911234567"
     * @return string phone number with operator code, like "911234567"
     */

    public function asShortPhoneNumber($value)
    {

        $phoneNumber = str_replace('+', "", $value);

        if (strlen($phoneNumber) == 12) {
            $phoneNumber = substr($phoneNumber, 3);
        }
        return $phoneNumber;
    }

    public function fullMonthName($monthNumber = 0)
    {
        switch ($monthNumber) {

            case '01' :
                return Yii::t('site', 'January');
            case '02' :
                return Yii::t('site', 'February');
            case '03' :
                return Yii::t('site', 'March');
            case '04' :
                return Yii::t('site', 'April');
            case '05' :
                return Yii::t('site', 'May');
            case '06' :
                return Yii::t('site', 'June');
            case '07' :
                return Yii::t('site', 'July');
            case '08' :
                return Yii::t('site', 'August');
            case '09' :
                return Yii::t('site', 'September');
            case '10' :
                return Yii::t('site', 'October');
            case '11' :
                return Yii::t('site', 'November');
            case '12' :
                return Yii::t('site', 'December');
            default:
                return false;
        }
    }

    public function asGmtime($value = null)
    {
        if ($value == null) {
            return "";
        }
        $value = intval($value);
        $format = $value >= 3600 ? "H:i:s" : "i:s";
        return gmdate($format, $value);
    }

    public function asFileSize($value = null)
    {
        if ($value == null) {
            return $this->nullDisplay;
        }
        $size = intval($value);
        if ($size <= 0) {
            return '';
        }

        if ($size < 1024) {
            return $this->asDecimal($size, 2) . " Bayt";
        }
        if ($size < 1024 * 1024) {
            return $this->asDecimal($size / 1024, 2) . " KB";
        }
        return $this->asDecimal($size / 1024 / 1024, 2) . " MB";

    }

}

?>