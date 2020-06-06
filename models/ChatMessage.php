<?php

namespace app\models;

use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class ChatMessage extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_message';
    }
}
