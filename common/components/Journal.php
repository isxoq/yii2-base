<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 10.08.2021, 10:40
 */

namespace common\components;


class Journal
{

    /**
     * @param $analizGroups \common\models\AnalizGroup[]
     */
    public static function umumiyQonJurnalNatijalari($analizGroups)
    {
        $results = [];

        foreach ($analizGroups as $analizGroup) {

            $item['i'] = $analizGroup->getOrderedNumber();
            $item['name'] = $analizGroup->client->lastnameAndFirstname;
            $item['born'] = date('d.m.Y', $analizGroup->client->born_date);
            $item['address'] = $analizGroup->client->address;
            $item['doctor'] = $analizGroup->analiz->doctor->name ?? '';

            /** @var int|float|null Gemoglobin (HB) */
            $hb = $analizGroup->getResultByIndicatorSlug('qu_hb');

            /** @var int|float|null Eritrositlar (RBC) */
            $rbc = $analizGroup->getResultByIndicatorSlug('qu_rbc');

            // Rank ko'rsatkichini hisoblash
            $rang_k = Formula::computeRangKorsatkich($hb, $rbc);

            $item['hb'] = $hb;
            $item['rbc'] = $rbc;
            $item['rk'] = $rang_k;
            $item['plt'] = $analizGroup->getResultByIndicatorSlug('qu_plt');
            $item['wbc'] = $analizGroup->getResultByIndicatorSlug('qu_wbc');
            $item['hct'] = $analizGroup->getResultByIndicatorSlug('qu_hct');
            $item['tyn'] = $analizGroup->getResultByIndicatorSlug('qu_tyn');
            $item['syn'] = $analizGroup->getResultByIndicatorSlug('qu_syn');
            $item['eoz'] = $analizGroup->getResultByIndicatorSlug('qu_eozinofil');
            $item['baz'] = $analizGroup->getResultByIndicatorSlug('qu_bazofil');
            $item['lim'] = $analizGroup->getResultByIndicatorSlug('qu_limfosit');
            $item['mon'] = $analizGroup->getResultByIndicatorSlug('qu_monosit');
            $item['echt'] = $analizGroup->getResultByIndicatorSlug('qu_echt');
            $item['iv'] = $analizGroup->getResultByIndicatorSlug('qu_ivish_vaqti');

            $results[] = $item;

        }

        return $results;
    }

}