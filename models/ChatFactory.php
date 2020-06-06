<?php

namespace app\models;

class ChatFactory
{
    public static function create(): IChat
    {
        return new ChatStorage();
    }
}
