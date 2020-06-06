<?php

use yii\db\Migration;

/**
 * Class m200603_130709_nt_chat
 */
class m200603_130709_nt_chat extends Migration
{
    public function up()
    {
        $this->createTable('chat_message', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'content' => $this->string(255),
            'created_at' => $this->integer()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('chat_message');
    }
}
