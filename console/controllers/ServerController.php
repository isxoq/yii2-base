<?php
/*
Project Name: taxi.loc
File Name: ServerController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/22/2021 9:23 AM
*/


namespace console\controllers;

use consik\yii2websocket\WebSocketServer;
use console\daemons\CommandsServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStart()
    {

        $server = new CommandsServer();
        $server->port = 80; //This port must be busy by WebServer and we handle an error

        $server->on(CommandsServer::EVENT_WEBSOCKET_OPEN_ERROR, function ($e) use ($server) {
            echo "Error opening port " . $server->port . "\n";
            $server->port += 1; //Try next port to open
            $server->start();
        });

        $server->on(CommandsServer::EVENT_WEBSOCKET_OPEN, function ($e) use ($server) {
            echo "Server started at port " . $server->port;
        });

        $server->start();
    }
}