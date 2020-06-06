<?php

namespace app\models;

class ChatStorage implements IChat
{

    public function saveMessage($name, $message)
    {
        $chat = new ChatMessage();
        $chat->name = $name;
        $chat->content = $message;
        $chat->created_at = time();
        $chat->save();
    }

    public function findMessagesAsArray()
    {
        return ChatMessage::find()->where('(FROM_UNIXTIME(created_at) + interval 1 day) >= now()')->asArray()->all();
    }
}
