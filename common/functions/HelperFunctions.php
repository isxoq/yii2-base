<?php
/*
Project Name: taxi.loc
File Name: HelperFunctions.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/30/2021 2:26 PM
*/

if (!function_exists('clearPhone')) {
    /**
     * @param $phoneNumber
     * @return string
     */
    function clearPhone($phoneNumber): string
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
    function removeCountryCode(string $phone)
    {

        if (empty($phone)) {
            return $phone;
        }

        $phone = clearPhone($phone);
        $length = strlen($phone);
        if ($length > 9) {
            $start = $length - 9;
            $phone = substr($phone, $start);
        }

        return $phone;
    }

    function addCountryCode($phone, $addPlus = false)
    {
        if (empty($phone)) {
            return $phone;
        }

        $phone = removeCountryCode($phone);
        $code = $addPlus ? '+998' : '998';
        return $code . $phone;
    }

    /**
     * Localhost ekanligini aniqlaydi
     * @return bool
     */
    function is_localhost(): bool
    {
        $whitelist = array(
            '127.0.0.1',
            'localhost',
            '::1'
        );

        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return true;
        }

        return false;
    }

    /**
     * Kod generatsiya qiladi
     * @param int $limit
     * @return int
     */
    function generateCode(): int
    {

        return 12345;

        if (is_localhost()) {
            return 123456;
        } else {
            return mt_rand(111111, 999999);
        }

    }


}