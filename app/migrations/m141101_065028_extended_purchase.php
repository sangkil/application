<?php

use yii\db\Schema;
use yii\db\Migration;

class m141101_065028_extended_purchase extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ext_purchase}}', [
            'id' => Schema::TYPE_INTEGER,
            'tax' => Schema::TYPE_FLOAT,
            'freight' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY ([[id]])',
            'FOREIGN KEY ([[id]]) REFERENCES {{%purchase}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%ext_purchase}}');
    }
}