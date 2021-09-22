<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 09.08.2021, 18:20
 */

namespace common\components;

use Yii;

class Formula
{

    //<editor-fold desc="Umumiy qon formulalari" defaultstate="collapsed">


    /**
     * Rang ko'rsatkichini hisoblash
     * @param $hb float|int|null Gemoglobin (HB)
     * @param $rbc float|int|null Eritrositlar (RBC)
     * @return string
     */
    public static function computeRangKorsatkich($hb, $rbc)
    {
        $hb = floatval($hb);
        $rbc = floatval($rbc);

        if (empty($hb) || empty($rbc)) {
            return '';
        }
        return Yii::$app->formatter->asDecimal($hb * 3 / ($rbc * 100));
    }

    /**
     * 1 dona eritrositdagi gemoglobinning miqdori (MCH) ni hisoblash
     * @param $hb float|int|null Gemoglobin (HB)
     * @param $rbc float|int|null Eritrositlar (RBC)
     * @return string
     */
    public static function computeGemoglobinMCH($hb, $rbc)
    {
        $hb = floatval($hb);
        $rbc = floatval($rbc);

        if (empty($hb) || empty($rbc)) {
            return '';
        }
        return Yii::$app->formatter->asDecimal($hb / $rbc);
    }

    /**
     * 1 Eritrositlar o‘rtacha xajmi (MCV) ni hisoblash
     * @param $hct float|int|null Gematokrit (HCT)
     * @param $rbc float|int|null Eritrositlar (RBC)
     * @return string
     */
    public static function computeEritrositMCV($hct, $rbc)
    {
        $hct = floatval($hct);
        $rbc = floatval($rbc);

        if (empty($hct) || empty($rbc)) {
            return '';
        }
        return Yii::$app->formatter->asDecimal($hct * 10 / $rbc);
    }

    /**
     * Eritrositdagi gemoglobin konsentratsiyasi (MCHS) ni hisoblash
     * @param $hb float|int|null Gemoglobin (HB)
     * @param $hct float|int|null Gematokrit (HCT)
     * @return string
     */
    public static function computeGemoglobinMCHS($hb, $hct)
    {
        $hb = floatval($hb);
        $hct = floatval($hct);

        if (empty($hb) || empty($hct)) {
            return '';
        }

        return Yii::$app->formatter->asDecimal($hb * 100 / $hct);
    }


    //</editor-fold>

    /**
     *  Bilirubin: Erkinni hisoblash
     * @param $bu int|null Bilirubin: Umumiy
     * @param $bb int|null    Bilirubin: Bog'langan
     */
    public static function computeFreeBilirubins($bu, $bb)
    {
        $bu = floatval($bu);
        $bb = floatval($bb);

        if (empty($bu) || empty($bb)) {
            return '';
        }
        return $bu - $bb;
    }
}