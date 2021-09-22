<?php

namespace frontend\modules\chat\models;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

/**
 *
 * @property-read mixed $data
 */
class Storage extends Component
{

    public $fileName;

    public function init()
    {
        parent::init();

        if (empty($this->fileName)) {
            $this->fileName = Yii::getAlias('@frontend') . '/modules/chat/files/data.json';
        }
    }

    public function add($string)
    {

        $input = Json::decode($string);

//        if (isset($input['msg']) && $input['msg'] == '/reset') {
//            $this->reset();
//        }

        $data = $this->getData();

        $data[] = $input;
        return file_put_contents($this->fileName, Json::encode($data));

    }

    public function reset()
    {
        $data = [];

        file_put_contents($this->fileName, json_encode($data));

    }

    public function getData()
    {
        if (!file_exists($this->fileName)) {
            $this->reset();
        }

        $string = file_get_contents($this->fileName);
        return Json::decode($string);
    }


}