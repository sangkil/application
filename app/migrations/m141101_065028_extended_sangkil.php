<?php

use yii\db\Schema;
use yii\db\Migration;

class m141101_065028_extended_sangkil extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%global_config}}', [
            'group' => Schema::TYPE_STRING . '(32) NOT NULL',
            'name' => Schema::TYPE_STRING . '(32) NOT NULL',
            'raw_value' => Schema::TYPE_TEXT,
            'description' => Schema::TYPE_STRING,
            // history column
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'updated_by' => Schema::TYPE_INTEGER,
            // constrain
            'PRIMARY KEY ([[group]], [[name]])',
            ], $tableOptions);
/*
        $this->createTable('{{%ext_purchase}}', [
            'id' => Schema::TYPE_INTEGER,
            'tax' => Schema::TYPE_FLOAT,
            'freight' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY ([[id]])',
            'FOREIGN KEY ([[id]]) REFERENCES {{%purchase}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
*/
    }

    public function safeDown()
    {
//        $this->dropTable('{{%ext_purchase}}');
        $this->dropTable('{{%global_config}}');
    }
}