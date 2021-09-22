<?php


namespace common\models\query;


use common\models\Order;
use soft\db\ActiveQuery;

class OrderQuery extends ActiveQuery
{

    public function waiting()
    {
        return $this->andWhere(['order.status' => Order::STATUS_NEW]);
    }

}