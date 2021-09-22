<?php


namespace soft\db;

use Yii;

/**
 * Trait ActiveRecordTrait - ActiveRecord uchun find() metodlari
 * @package soft\db
 */
trait ActiveRecordTrait
{

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return new \soft\db\ActiveQuery(get_called_class());
    }

    /**
     * Jadvaldagi Barcha yozuvlarni topish
     * @param int $limit
     * @param int $offset
     * @return static[]
     */
    public static function getAll($limit = 0, $offset = 0)
    {

        $query = static::find();
        if ($limit > 0) $query->limit($limit);
        if ($offset > 0) $query->offset($offset);
        return $query->all();

    }

    /**
     * Berilgan $id qiymat bo'yicha modelni topish
     * @param string $id
     * @return static
     * @throws yii\web\NotFoundHttpException
     */
    public static function findModel($id='')
    {
        $model = static::find()->where(['id' => $id])->one();
        if ($model == null) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app',"Page not found!"));
        }
        return $model;
    }

    /**
     * Jadvaldag activ modelni topish
     * DIQQAT: Bu metoddan foydalanish uchun jadvalda status degan maydon bo'lishi zarur
     * @param string $id
     * @return static
     */
    public static function findActiveOne($id='')
    {
        $tableName = static::tableName();
        return static::find()->where(['id' => $id])->andWhere([$tableName.'.status' => ActiveRecord::STATUS_ACTIVE])->one();
    }

    /**
     * Aktiv modelni topish
     * @param string $id
     * @return static
     * @throws \yii\web\NotFoundHttpException - agar model topilmasa yoki aktiv bo'lmasa
     */
    public static function findActiveModel($id='')
    {
        $model = static::findActiveOne($id);
        if ($model == null) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app',"Page not found!"));
        }
        return $model;
    }

}