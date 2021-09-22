<?php

namespace common\models;

use common\models\query\OrderQuery;
use soft\helpers\ArrayHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $address_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $driver_id [int(11)]
 * @property int $car_id [int(11)]
 * @property string $begin_lang [varchar(255)]
 * @property string $begin_long [varchar(255)]
 * @property string $end_lang [varchar(255)]
 * @property string $end_long [varchar(255)]
 *
 * @property Address $address
 * @property Client $client
 * @property User $createdBy
 * @property-read Car $car
 * @property-read  Driver $driver
 * @property-read string $clientPhone
 * @property-read string $addressName
 * @property-read null|string $bsPrefix
 * @property User $updatedBy
 */
class Order extends \soft\db\ActiveRecord
{

    const STATUS_NEW = 5; // new and waiting orders
    const STATUS_ACCEPTED = 6;
    const STATUS_ON_ROAD = 7;
    const STATUS_COMPLETED = 8;
    const STATUS_CANCELLED_BY_ADMIN = 4;

    /**
     * Haydovchi klientga tel qilganda, agar klient 'uzr, boshqa mashina kelib qoldi' yoki
     * shunga o'xshash gaplarni aytib, otmen qilsa, haydovchi buyurtmani otmen qildadi va
     * buyurtma statusi shu qiymatga teng bo'ladi. Bu holatda buyurtma faqat adminga ko'rinadi.
     * Admin klient bilan gaplashib, xoxlasa buyurtmani bekor qiladi (bunda self::STATUS_CANCELLED_BY_CLIENT qiymatga teng bo'ladi)
     * yoki qaytadan kutish rejimiga o'tkazadi (self::STATUS_NEW)
     * @see self::STATUS_CANCELLED_BY_CLIENT
     */
    const STATUS_CANCELLED_BY_DRIVER = 3;

    /**
     * @see self::STATUS_CANCELLED_BY_DRIVER
     */
    const STATUS_CANCELLED_BY_CLIENT = 2;

    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'address_id', 'status'], 'integer'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public function fields()
    {
        return ArrayHelper::getValue(Yii::$app->params, 'orderFields', parent::fields());
    }

    /**
     * @return \common\models\query\OrderQuery
     */
    public static function find()
    {
        return new OrderQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'client_id' => 'Mijoz',
            'address_id' => 'Manzil',
        ];
    }



    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(Driver::className(), ['id' => 'driver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::className(), ['id' => 'car_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>

    //<editor-fold desc="Types" defaultstate="collapsed">

    public static function typeLabels()
    {
        return [
            self::STATUS_NEW => 'Yangi',
            self::STATUS_ACCEPTED => 'Qabul qilindi',
            self::STATUS_ON_ROAD => "Yo'lda",
            self::STATUS_COMPLETED => 'Bajarildi!',
            self::STATUS_CANCELLED_BY_ADMIN => 'Admin tomonidan bekor qilindi',
            self::STATUS_CANCELLED_BY_DRIVER => 'Haydovchi tomonidan bekor qilindi', // klientning aybi bilan
            self::STATUS_CANCELLED_BY_CLIENT => 'Mijoz tomonidan bekor qilindi',
        ];
    }

    public static function typeBsPrefixes()
    {
        return [
            self::STATUS_NEW => 'warning',
            self::STATUS_ACCEPTED => 'info',
            self::STATUS_ON_ROAD => "primary",
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CANCELLED_BY_ADMIN => 'secondary',
            self::STATUS_CANCELLED_BY_DRIVER => 'danger', // klientning aybi bilan
            self::STATUS_CANCELLED_BY_CLIENT => 'secondary',
        ];
    }

    /**
     * @return string
     */
    public function getBsPrefix()
    {
        return ArrayHelper::getArrayValue(self::typeBsPrefixes(), $this->status, 'default');
    }

    //</editor-fold>

    //<editor-fold desc="Static methods" defaultstate="collapsed">


    /**
     * @param string $phone
     * @param string $address
     * @return \common\models\Order|false
     */
    public static function addOrder($phone, $address = '')
    {

        if (empty($phone) || empty($address)) {
            return false;
        }

        $client = Client::findOrCreate($phone);
        if ($client) {
            $address = Address::findOrCreate($address);
            if ($address) {
                $model = new Order();
                $model->client_id = $client->id;
                $model->address_id = $address->id;
                if ($model->save()) {
                    return $model;
                }
            }
        }

        return false;

    }


    //</editor-fold>

    //<editor-fold desc="Additional attributes" defaultstate="collapsed">

    /**
     * @return string
     */
    public function getAddressName()
    {
        return $this->address->name ?? '';
    }

    /**
     * @return string
     */
    public function getClientPhone()
    {
        return $this->client->phone ?? '';
    }


    //</editor-fold>

    //<editor-fold desc="Driver" defaultstate="collapsed">

    public function accepted(Driver $driver)
    {
        return true;
    }

    //</editor-fold>
}
