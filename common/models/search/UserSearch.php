<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 18.07.2021, 9:31
 */

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearch extends User
{

    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'type_id'], 'integer'],
            [['username', 'first_name', 'last_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($query = null, $defaultPageSize = 20, $params = null)
    {

        if ($params == null) {
            $params = Yii::$app->request->queryParams;
        }
        if ($query == null) {
            $query = User::find();
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name]);

        return $dataProvider;
    }
}
