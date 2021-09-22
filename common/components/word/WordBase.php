<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 10.08.2021, 14:37
 */

namespace common\components\word;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\JcTable;
use soft\helpers\FileHelper;
use Yii;
use yii\base\Component;

/**
 * Class WordBase is base class of word-journal renderer classes
 * @package common\components\word
 */
abstract class WordBase extends Component
{

    public $rowsPerPage = 20;

    public $filePrefix = 'Jurnal';

    public $defaultFontName = 'Times New Roman';
    public $defaultFontSize = 10;

    public $sectionStyle = [
        'orientation' => 'landscape',
        'marginTop' => 500,
        'marginBottom' => 500,
        'marginLeft' => 600,
        'alignment' => 'center',
    ];

    public $tableStyle = [
        'borderSize' => 6,
        'alignment' => JcTable::CENTER,
    ];


    /**
     * @param $table \PhpOffice\PhpWord\Element\Table
     * @return mixed
     */
    abstract public function renderTableHeader($table);

    /**
     * @param $table \PhpOffice\PhpWord\Element\Table
     * @param $analizGroups \common\models\AnalizGroup[]
     * @return mixed
     */
    abstract public function renderTableContent($table, $analizGroups);

    /**
     * @param $analizGroups \common\models\AnalizGroup[]
     * @throws \PhpOffice\PhpWord\Exception\Exception
     * @throws \yii\base\Exception
     */
    public function renderJournalTable($analizGroups, $download = true)
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName($this->defaultFontName);
        $phpWord->setDefaultFontSize($this->defaultFontSize);

        $rowsPerPage = $this->rowsPerPage;
        $countRows = count($analizGroups);
        $index = 0;

        while ($index <= $countRows) {
            $groups = array_slice($analizGroups, $index, $rowsPerPage);
            $index += $rowsPerPage;
            $isLastPage = $index > $countRows;
            $this->renderSinglePage($phpWord, $groups, $isLastPage);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');

        $dirPath = Yii::getAlias('@frontend') . "/web/docs";

        if (!is_dir($dirPath)) {
            FileHelper::createDirectory($dirPath);
        }

        $fileName = $this->filePrefix . '-' . date('Y-m-d') . ' ' . mt_rand() . '.docx';

        $file = $dirPath . '/' . $fileName;

        $objWriter->save($file);

        if ($download) {
            Yii::$app->response->sendFile($file);
            unlink($file);
        }

    }

    /**
     * @param $phpWord PhpWord
     * @param $analizGroups \common\models\AnalizGroup[]
     * @param $isLastPage bool
     */
    public function renderSinglePage($phpWord, $analizGroups, $isLastPage = false)
    {
        $section = $phpWord->addSection($this->sectionStyle);
        $phpWord->addTableStyle('tableStyleName', $this->tableStyle);
        $table = $section->addTable('tableStyleName');

        $this->renderTableHeader($table);
        $this->renderTableContent($table, $analizGroups);

        if (!$isLastPage) {
            $section->addPageBreak();
        }
    }


    /**
     * @param $table \PhpOffice\PhpWord\Element\Table
     * @param int $number
     */
    public function generateNullCells($table, $number = 1)
    {
        for ($i = 1; $i <= $number; $i++) {
            $table->addCell(null, ['vMerge' => 'continue']);
        }
    }

}