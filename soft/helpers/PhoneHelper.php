<?php

namespace soft\helpers;

class PhoneHelper
{

    public static function clear($phoneNumber)
    {
        $tel = trim($phoneNumber);
        return strtr($tel, [
            "+" => '',
            " " => '',
            "(" => '',
            ")" => '',
            "-" => '',
        ]);
    }

    /**
     * Telefon raqamdan davlat kodi (+998) ni olib tashlaydi
     * @param string $phone
     * @return false|string|null
     */
    public static function removeCountryCode($phone)
    {

        if (empty($phone)) {
            return $phone;
        }

        $phone = self::clear($phone);
        $length = strlen($phone);
        if ($length > 9) {
            $start = $length - 9;
            $phone = substr($phone, $start);
        }

        return $phone;
    }

    public static function addCountryCode($phone, $addPlus = false)
    {
        if (empty($phone)) {
            return $phone;
        }

        $phone = static::removeCountryCode($phone);
        $code = $addPlus ? '+998' : '998';
        return $code . $phone;
    }

}