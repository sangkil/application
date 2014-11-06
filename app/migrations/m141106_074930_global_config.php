<?php

use yii\db\Schema;
use yii\db\Migration;

class m141106_074930_global_config extends Migration
{

    public function safeUp()
    {
        $rows = [
            ['group' => 'GROUP_SCHEMA', 'name' => 'GM_REFF_TYPE',
                'value' => serialize(['class', 'relation', 'qty_field', 'total_field'])
            ],
        ];
        $now = new yii\db\Expression('NOW()');
        foreach ($rows as $row) {
            $row['created_at'] = $row['updated_at'] = $now;
            $this->insert('{{%global_config}}', $row);
        }
    }

    public function safeDown()
    {
        $rows = [
            ['group' => 'GROUP_SCHEMA', 'name' => 'GM_REFF_TYPE'],
        ];
        foreach ($rows as $row) {
            $this->delete('{{%global_config}}', $row);
        }
    }
}