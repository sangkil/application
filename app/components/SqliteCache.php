<?php

namespace app\components;

use Yii;
use yii\db\Connection;

/**
 * SqliteCache
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SqliteCache extends \yii\caching\DbCache
{
    /**
     * @var Connection|string the DB connection object or the application component ID of the DB connection.
     * After the DbCache object is created, if you want to change this property, you should only assign it
     * with a DB connection object.
     */
    public $db;

    /**
     * @var string Db file name.
     */
    public $dbFile = '@runtime/cache.sqlite.db';

    /**
     * @var boolean whether the cache DB table should be created automatically if it does not exist. Defaults to true.
     * If you already have the table created, it is recommended you set this property to be false to improve performance.
     */
    public $autoCreateTable = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->db === null) {
            $this->db = new Connection([
                'dsn' => 'sqlite:' . Yii::getAlias($this->dbFile),
            ]);
        }
        parent::init();
        if ($this->autoCreateTable && !$this->db->getTableSchema($this->cacheTable)) {
            $this->createTableCache();
        }
    }

    /**
     * Creates the cache DB table.
     */
    protected function createTableCache()
    {
        $sql = <<<EOD
CREATE TABLE {$this->cacheTable}
(
	id char(128) NOT NULL PRIMARY KEY,
	expire INTEGER,
	data BLOB
)
EOD;
        $this->db->createCommand($sql)->execute();
    }
}