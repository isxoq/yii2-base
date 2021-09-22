<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%temp_number}}`.
 */
class m210830_091523_create_temp_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%temp_number}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(100),
            'last_name' => $this->string(100),
            'password' => $this->string(),
            'phone_number' => $this->string(100),
            'code' => $this->integer(6),
            'expire_at' => $this->integer(),
            'type' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%temp_number}}');
    }
}
