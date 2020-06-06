<?php

namespace app\server;

use consik\yii2websocket\events\WSClientErrorEvent;
use consik\yii2websocket\WebSocketServer;
use consik\yii2websocket\events\WSClientMessageEvent;

use Ratchet\ConnectionInterface;
use app\models\ChatFactory;

class ChatServer extends WebSocketServer
{

    /**
     * @var $model \app\models\IChat
     */
    protected $model;

    public function init()
    {
        parent::init();
        $this->model = ChatFactory::create();
    }

    protected function getCommand(ConnectionInterface $from, $msg)
    {
        $request = json_decode($msg, true);
        return !empty($request['action']) ? $request['action'] : parent::getCommand($from, $msg);
    }

    protected function commandSendMessage(ConnectionInterface $client, $msg)
    {
        $request = json_decode($msg, true);
        $message = $request['message'] ?? '';
        $message = trim($message);
        if (empty($message)) {
            $client->send(json_encode(['message' => 'Сообщение не может быть пустым']));
        } else {
            if (empty($client->name)) {
                $client->name = $message;
                $client->send(json_encode([
                    'message' => 'Имя установлено: ' . $message,
                    'action' => 'name',
                ]));
            } else {
                $this->model->saveMessage($client->name, $message);

                foreach ($this->clients as $chatClient) {
                    $chatClient->send(json_encode([
                        'action' => 'chat',
                        'name' => $client->name,
                        'content' => $message
                    ]));
                }
            }
        }
    }

    protected function commandGetHistory(ConnectionInterface $client, $msg)
    {
        $items = $this->model->findMessagesAsArray();
        $answer = ['action' => 'history', 'items' => $items];
        $client->send(json_encode($answer));
    }

}