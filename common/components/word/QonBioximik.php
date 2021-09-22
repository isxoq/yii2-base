<?php

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 10.08.2021, 14:40
 */

namespace common\components\word;

use common\components\Formula;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Cell;

class QonBioximik extends WordBase
{

    public $rowsPerPage = 18;

    public $filePrefix = 'Bioximik qon jurnali';

    /**
     * @param \PhpOffice\PhpWord\Element\Table $table
     */
    public function renderTableHeader($table)
    {
        $cellPStyle = ['alignment' => 'center', 'spaceAfter' => 2, 'spaceBefore' => 2];

        $cellStyle = ['valign' => 'center'];
        $cellRowContinue = ['vMerge' => 'continue'];

        $table->addRow(Converter::cmToTwip(0.42));

        $table->addCell(Converter::cmToTwip(0.87), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('№', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(1.9), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('Sana', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(4.5), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('F.I.SH', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Yoshi', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(4.5), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('Manzili', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(3.75), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('Yuborgan vrachi', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('ALT', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('AST', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Glyukoza', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(3), ['valign' => 'center', 'gridSpan' => 3])
            ->addText("Bilirubin", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Mochevina', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Timol', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Kreatinin', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Xolister', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Kalsiy', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Ob belok', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('SRB', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('RF', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.18), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('ASO', null, $cellPStyle);

//        second row
        $table->addRow(Converter::cmToTwip(2));

        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);

        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Umumiy', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Bog'langan", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Erkin', null, $cellPStyle);

        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);

    }

    /**
     * @param \PhpOffice\PhpWord\Element\Table $table
     * @param \common\models\AnalizGroup[] $analizGroups
     */
    public function renderTableContent($table, $analizGroups)
    {

        foreach ($analizGroups as $analizGroup) {

            $table->addRow(Converter::cmToTwip(0.2));

            $cellStyle = ['valign' => 'center'];
            $cellPStyle = ['alignment' => 'center', 'spaceAfter' => 2, 'spaceBefore' => 2];

            $table->addCell(null, $cellStyle)->addText($analizGroup->orderedNumber, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText(date('d.m.Y', $analizGroup->created_at), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->lastnameAndFirstname, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->age, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->address, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->analiz->doctor->name ?? '', null, $cellPStyle);

            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_alt'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_ast'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText( $analizGroup->getResultByIndicatorSlug('qb_glyukoza'), null, $cellPStyle);


            /** @var int|null Bilirubin: Umumiy */
            $bu = $analizGroup->getResultByIndicatorSlug('qb_u_bilirubin');

            /** @var int|null Bilirubin: Bog'langan */
            $bb = $analizGroup->getResultByIndicatorSlug('qb_b_bilirubin');

            //   Bilirubin: Erkinni hisoblash
            $be = Formula::computeFreeBilirubins($bu, $bb);

            $table->addCell(null, $cellStyle)->addText($bu, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($bb, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($be, null, $cellPStyle);

            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_mochevina'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_timol'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_kreatinin'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_u_xolesterin'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_kalsiy'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_ob_belok'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_srb'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_rf'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qb_aso'), null, $cellPStyle);

        }

    }

}