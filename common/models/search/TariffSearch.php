<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tariff;

class TariffSearch extends Tariff
{

    public function rules()
    {
        return [
            [['id', 'minimum_km', 'minimum_sum', 'km_sum', 'status', 'outra_city_km_sum', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($query=null, $defaultPageSize = 20, $params=null)
    {

        if($params == null){
            $params = Yii::$app->request->queryParams;
        }
        if($query == null){
            $query = Tariff::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'minimum_km' => $this->minimum_km,
            'minimum_sum' => $this->minimum_sum,
            'km_sum' => $this->km_sum,
            'status' => $this->status,
            'outra_city_km_sum' => $this->outra_city_km_sum,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
