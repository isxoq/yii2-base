<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Car;

class CarSearch extends Car
{

    public function rules()
    {
        return [
            [['id', 'driver_id', 'model_id', 'position', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['image', 'color', 'number', 'description'], 'safe'],
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
            $query = Car::find();
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
            'driver_id' => $this->driver_id,
            'model_id' => $this->model_id,
            'position' => $this->position,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
