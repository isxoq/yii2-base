<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m210713_052152_add_columns_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'first_name', $this->string(100));
        $this->addColumn('user', 'last_name', $this->string(100));
        $this->addColumn('user', 'phone', $this->string(100));
        $this->addColumn('user', 'image', $this->string());
        $this->addColumn('user', 'type_id', $this->tinyInteger(2)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'phone');
        $this->dropColumn('user', 'image');
        $this->dropColumn('user', 'type_id');
    }
}
