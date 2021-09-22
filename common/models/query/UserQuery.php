<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 16.07.2021, 14:21
 */

namespace common\models\query;

use common\models\User;

class UserQuery extends \soft\db\ActiveQuery
{

    /**
     * @return \common\models\query\UserQuery
     */
    public function manager()
    {
        return $this->andWhere(['user.type_id' => User::TYPE_MANAGER]);
    }

    /**
     * @return \common\models\query\UserQuery
     */
    public function consultant()
    {
        return $this->andWhere(['user.type_id' => User::TYPE_CONSULTANT]);
    }

}