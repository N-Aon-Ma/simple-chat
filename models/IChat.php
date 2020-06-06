<?php

namespace app\models;


interface IChat
{
    public function findMessagesAsArray();

    public function saveMessage($name, $message);
}
