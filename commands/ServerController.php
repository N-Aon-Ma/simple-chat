<?php

namespace app\commands;

use app\models\ChatMessage;
use app\server\ChatServer;
use yii\console\Controller;

class ServerController extends Controller
{

    public function actionStart()
    {
        $server = new ChatServer();
        $server->port = 8000;
        $server->start();
    }
}