<?php
/*
Project Name: taxi.loc
File Name: CommandsServer.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/22/2021 9:25 AM
*/

namespace console\daemons;

use Yii;
use common\models\Order;
use console\models\AuthAssignment;
use common\models\User;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\WebSocketServer;
use Ratchet\ConnectionInterface;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

/**
 *
 * @property-read null|object[] $waitingOrders
 */
class CommandsServer extends WebSocketServer
{

    public function onMessage(ConnectionInterface $from, $msg)
    {
        try {
            $data = Json::decode($msg, false);

            if ($data->command == "auth") {
                $this->authHandler($from, $data);
                return;
            }

            if ($this->validateData($data)) {
                $this->handler($from, $data);
            } else {
                $from->send($this->error(t("Malumotlar yetarli emas!"), $data));
            }

        } catch (\Exception $e) {
            $from->send($this->error(t($e->getMessage()), $data));
        }
    }

    public function validateData($data): bool
    {
        return property_exists($data, 'command') && property_exists($data, 'token');
    }

    /**
     * @param $from
     * @param $data
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function handler($from, $data)
    {
        switch ($data->command) {
            case "new_order":
            {
                $this->sendNewOrder($from, $data);
                break;
            }
            case "take_order":
            {
                $this->takeOrder($from, $data);
                break;
            }
            default:
            {
                $this->messageHandler($from, $data);
                break;
            }
        }
    }

    public function takeOrder($from, $data)
    {
        $res = $this->takeOrderByDriver($data);
        $from->send($this->success(t("Success"), [
            'type' => 'update_orders',
            'data' => $res
        ]));
    }

    /**
     * @param $from
     * @param $data
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function sendNewOrder($from, $data)
    {
        if ($this->receptionAuth($from, $data)) {
            foreach ($this->clients as $client) {
                if ($client->status == 1) {
                    $client->send($this->success(t("Zakazlar o'zgarishi!"), [
                        'type' => 'update_orders',
                        'data' => $this->getWaitingOrders()
                    ]));
                }
            }
        } else {
            $from->send($this->error(t('Sizga bu amalga ruxsat berilmagan!'), []));
        }
    }

    /**
     * @param $from
     * @param $data
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function receptionAuth($from, $data)
    {
        $user = User::find()->andWhere(['auth_key' => $data->token])->createCommand()->getRawSql();
        $userObject = $this->getSqlResult($user);

        if (!$userObject) {
            return false;
        } else {

            $auth_item = AuthAssignment::find()->andWhere(['item_name' => 'send_new_order', 'user_id' => $userObject->id])->createCommand()->getRawSql();
            $auth_item = $this->getSqlResult($auth_item);

            if ($auth_item) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @param $from
     * @param $data
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function authHandler($from, $data)
    {
        $user = User::find()->andWhere(['auth_key' => $data->token, 'status' => User::STATUS_ACTIVE, 'type_id' => User::TYPE_CLIENT])->createCommand()->getRawSql();

        $userObject = $this->getSqlResult($user);

        if ($userObject) {
            $from->status = 1;
            $from->token = $userObject->auth_key;

            $orders = $this->getWaitingOrders();
            $from->send($this->success([
                'orders' => $orders,
            ]));
        } else {
            $from->send($this->error(t("Tokenda Xatolik!"), $data));
        }
    }

    public function messageHandler($from, $data)
    {

    }

    /**
     * @param \Ratchet\ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $conn->status = 0;
        $conn->token = "";

        $this->trigger(self::EVENT_CLIENT_CONNECTED, new WSClientEvent([
            'client' => $conn
        ]));
        $this->clients->attach($conn);
        $conn->send($this->success());
    }


    //<editor-fold desc="Orders" defaultstate="collapsed">

    /**
     * @throws \yii\web\ForbiddenHttpException
     */
    protected function getWaitingOrders()
    {
        $sql = Order::find()
            ->select(['order.id', 'client.phone AS client_phone', 'address.name AS address_name'])
            ->latest()
            ->waiting()
            ->joinWith('address')
            ->joinWith('client')
            ->createCommand()
            ->getRawSql();

        return $this->getSqlResult($sql);

    }

    protected function takeOrderByDriver($data)
    {
        $user = User::find()->andWhere(['auth_key' => $data->token])->createCommand()->getRawSql();
        $userObject = $this->getSqlResult($user);

        $status = Order::STATUS_ACCEPTED;
        $sql = "UPDATE `order` SET `status`={$status},`driver_id`={$userObject->id}, `car_id`={$data->car_id} WHERE `id`={$data->order_id}";

        return $this->execSql($sql);

    }

    protected function execSql($sql)
    {
        $host = Yii::$app->params['db']['host'];
        $dbname = Yii::$app->params['db']['dbname'];
        $username = Yii::$app->params['db']['username'];
        $password = Yii::$app->params['db']['password'];

        $conn = new \mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new ForbiddenHttpException($conn->connect_error);
        }

        $result = $conn->query($sql);
        $error = $conn->error;
        $conn->close();

        return $error;
    }

    //</editor-fold>

    //<editor-fold desc="DB - SQL" defaultstate="collapsed">

    public function getSqlResult($sql)
    {

        $host = Yii::$app->params['db']['host'];
        $dbname = Yii::$app->params['db']['dbname'];
        $username = Yii::$app->params['db']['username'];
        $password = Yii::$app->params['db']['password'];

        $conn = new \mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new ForbiddenHttpException($conn->connect_error);
        }

        $sqlObject = null;
        $result = $conn->query($sql);
        $conn->close();
        if ($result->num_rows == 1) {
            // output data of each row
            $sqlObject = $result->fetch_assoc();

        } elseif ($result->num_rows > 1) {

            while ($row = $result->fetch_assoc()) {
                $sqlObject[] = $row;
            }

        } else {
            $sqlObject = null;
        }
        $sqlObject = $sqlObject ? (object)$sqlObject : null;

        return $sqlObject;
    }

    //</editor-fold>

    //<editor-fold desc="Response type" defaultstate="collapsed">

    protected function success($data = null, $message = 'success')
    {
        return Json::encode([
            'status' => 200,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function error($message = null, $status = 403)
    {
        return Json::encode([
            'status' => $status,
            'message' => $message,
        ]);
    }

    //</editor-fold>
}