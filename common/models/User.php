<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 29.07.2021, 11:29
 */

namespace common\models;

use backend\models\Hospital;
use soft\helpers\PhoneHelper;
use Yii;
use yii\db\ActiveRecord;
use soft\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use common\models\query\UserQuery;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $province_id
 * @property integer $region_id
 * @property integer $gender_id
 * @property integer $hospital_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read string $authKey
 * @property bool $type_id [tinyint(3)]
 * @property string $birth_date
 * @property string $first_name
 * @property string $last_name
 * @property string $father_name
 * @property string $phone [varchar(100)]
 * @property string $image [varchar(255)]
 *
 * @property-read mixed $statusName
 * @property-read string $statusBadge
 * @property-read string $fullname
 *
 * @property string $Host [char(60)]
 * @property string $User [char(32)]
 * @property int $max_questions [int(11) unsigned]
 * @property int $max_updates [int(11) unsigned]
 * @property int $max_connections [int(11) unsigned]
 * @property int $max_user_connections [int(11) unsigned]
 * @property string $plugin [char(64)]
 * @property string $authentication_string
 * @property string $password_expired [enum('N', 'Y')]
 * @property int $password_last_changed [timestamp]
 * @property int $password_lifetime [smallint(5) unsigned]
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const TYPE_CLIENT = 2;
    const TYPE_DOCTOR = 7;
    const TYPE_HOSPITAL_ADMIN = 4;
    const TYPE_ADMIN = 9;

    const SCENARIO_CREATE_CLIENT = 'create_client';
    const SCENARIO_UPDATE_CLIENT = 'update_client';
    const SCENARIO_API_CREATE_CLIENT = 'api_create_client';
    const SCENARIO_API_ADD_PROFILE_CLIENT = 'api_add_profile_client';
    const SCENARIO_GENERATE_AUTH_KEY = 'generate_auth_key';

    public $password;
    public $phoneField;

    //<editor-fold desc="Parent methods" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'unique', 'message' => 'Ushbu login avvalroq band qilingan.'],
            [['username'], 'string', 'max' => 100],
            [['first_name', 'last_name', 'father_name'], 'string', 'max' => 255],
            ['birth_date', 'required'],
            ['province_id', 'integer'],
            ['region_id', 'integer'],
            ['hospital_id', 'integer'],
            ['password', 'string', 'min' => 5],
            ['password', 'trim'],
            ['password', 'required', 'on' => [self::SCENARIO_CREATE_CLIENT]],

            ['phoneField', 'string'],
            ['phoneField', 'trim'],
            ['phoneField', 'required'],
            ['phoneField', 'match', 'pattern' => '/\+998\(\d{2}\) \d{3}\-\d{2}\-\d{2}/', 'message' => "Noto'g'ri telefon raqam!"],
            ['phoneField', 'checkUniquePhone'],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Login',
            'first_name' => 'Ism',
            'last_name' => 'Familiya',
            'password' => 'Parol',
            'type_id' => 'Xodim turi',
            'typeName' => 'Xodim turi',
            'created_at' => "Yaratildi",
            'updated_at' => "Tahrirlandi",
            'image' => 'Rasm',
            'phone' => "Tel. raqam",
            'phoneField' => "Tel. raqam",
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE_CLIENT] = ['username', 'first_name', 'last_name', 'password', 'image', 'phoneField'];
        $scenarios[self::SCENARIO_UPDATE_CLIENT] = ['username', 'first_name', 'last_name', 'password', 'image', 'phoneField'];
        $scenarios[self::SCENARIO_API_CREATE_CLIENT] = ['username', 'first_name', 'last_name', 'password', 'phone'];
        $scenarios[self::SCENARIO_API_ADD_PROFILE_CLIENT] = ['image', 'first_name', 'last_name', 'father_name', 'birth_date', 'gender', 'province_id', 'region_id'];
        $scenarios[self::SCENARIO_GENERATE_AUTH_KEY] = ['auth_key'];
        return $scenarios;
    }

    /**
     * @return \common\models\query\UserQuery|\yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find()
    {
        return Yii::createObject(UserQuery::class, [get_called_class()]);
    }

    //</editor-fold>

    //<editor-fold desc="Required methods" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @param $token
     * @param null $type
     * @return \common\models\User|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findHospitalAdmin($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'type_id' => self::TYPE_HOSPITAL_ADMIN]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $phone string
     * @return \common\models\User|null
     */
    public static function findByPhoneNumber($phone)
    {
        return static::findOne(['phone' => $phone, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString(16) . '_' . time();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    //</editor-fold>

    public function checkUniquePhone($attribute)
    {
        $phone = PhoneHelper::clear($this->phoneField);
        $model = static::findOne(['phone' => $phone]);
        if (!$this->isNewRecord && $this->id == $model->id) {
            return true;
        }
        if ($model != null) {
            $this->addError($attribute, "Ushbu telefon raqam avvalroq ro'yxatdan o'tgan!");
            return false;
        }
        return true;
    }

    //<editor-fold desc="Status" defaultstate="collapsed">

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE => 'Faol',
            self::STATUS_INACTIVE => 'Nofaol',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getArrayValue(self::statuses(), $this->status);
    }

    public function getStatusBadge(): string
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                return '<span class="badge badge-success">Faol</span>';
            default:
                return '<span class="badge badge-danger">Nofaol</span>';;
        }
    }

    //</editor-fold>

    //<editor-fold desc="Additional" defaultstate="collapsed">


    public function getHospital()
    {
        return $this->hasOne(Hospital::class, ['id' => 'hospital_id']);
    }

    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Driverni izlash
     * @throws \yii\base\InvalidConfigException
     */
    public static function findClient($username)
    {
        return self::find()
            ->andWhere(['username' => $username])
            ->andWhere(['type_id' => self::TYPE_CLIENT])
            ->one();
    }

    public static function findClientByAuthKey($auth_key)
    {
        return self::find()
            ->andWhere(['auth_key' => $auth_key])
            ->andWhere(['type_id' => self::TYPE_CLIENT])
            ->one();
    }

    //</editor-fold>

    //<editor-fold desc="RBAC" defaultstate="collapsed">

    public function can($permissionName, $params = [])
    {
        return Yii::$app->authManager->checkAccess($this->getId(), $permissionName, $params);
    }

    /**
     * @throws \Exception
     */
    public function assignRole(string $roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if ($role == null) {
            $role = $auth->createRole($roleName);
            $auth->add($role);
        }
        $auth->assign($role, $this->id);
    }

    /**
     * Revokes a role from a user.
     * @param $roleName string Role name
     * @throws \Exception
     */
    public function revokeRole($roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if ($role != null) {
            $assign = $auth->getAssignment($roleName, $this->id);
            if ($assign != null) {
                $auth->revoke($role, $this->id);
            }
        }
    }

    //</editor-fold>

    //<editor-fold desc="Types" defaultstate="collapsed">

    public function getIsDriver()
    {
        return $this->type_id == self::TYPE_CLIENT;
    }

    //</editor-fold>
}
