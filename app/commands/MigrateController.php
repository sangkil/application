<?php

namespace app\commands;

use Yii;
use yii\helpers\ArrayHelper;
use yii\console\Exception;

/**
 * Description of MigrateController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @var boolean Up, Down and Redo to version without affected to other migration.
     */
    public $specialAction = false;

    /**
     * @var array
     */
    public $migrationLookup = [];

    /**
     * @var array
     */
    private $_migrationFiles;

    /**
     * List of migration class at all entire path
     * @return array
     */
    protected function getMigrationFiles()
    {
        if ($this->_migrationFiles === null) {
            $this->_migrationFiles = [];
            $directories = array_merge($this->migrationLookup, [$this->migrationPath]);
            $extraPath = ArrayHelper::getValue(Yii::$app->params, 'yii.migrations');
            if (!empty($extraPath)) {
                $directories = array_merge((array) $extraPath, $directories);
            }

            foreach (array_unique($directories) as $dir) {
                $dir = Yii::getAlias($dir, false);
                if ($dir && is_dir($dir)) {
                    $handle = opendir($dir);
                    while (($file = readdir($handle)) !== false) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        }
                        $path = $dir . DIRECTORY_SEPARATOR . $file;
                        if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && is_file($path)) {
                            $this->_migrationFiles[$matches[1]] = $path;
                        }
                    }
                    closedir($handle);
                }
            }

            ksort($this->_migrationFiles);
        }

        return $this->_migrationFiles;
    }

    /**
     * @inheritdoc
     */
    protected function createMigration($class)
    {
        $file = $this->getMigrationFiles()[$class];
        require_once($file);

        return new $class(['db' => $this->db]);
    }

    /**
     * @inheritdoc
     */
    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $version => $time) {
            $applied[substr($version, 1, 13)] = true;
        }

        $migrations = [];
        foreach ($this->getMigrationFiles() as $version => $path) {
            if (!isset($applied[substr($version, 1, 13)])) {
                $migrations[] = $version;
            }
        }

        return $migrations;
    }

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        $options = parent::options($actionID);
        if (in_array($actionID, ['up', 'down', 'redo'])) {
            $options = array_merge($options, ['specialAction']);
        }
        return $options;
    }

    /**
     * @inheritdoc
     */
    public function actionUp($limit = 0)
    {
        if ($this->specialAction) {
            $version = $limit;
            if (preg_match('/^m?(\d{6}_\d{6})(_.*?)?$/', $version, $matches)) {
                $version = 'm' . $matches[1];
            } else {
                throw new Exception("The version argument must be either a timestamp (e.g. 101129_185401)\nor the full name of a migration (e.g. m101129_185401_create_user_table).");
            }

            $migrations = $this->getNewMigrations();
            foreach ($migrations as $migration) {
                if (strpos($migration, $version . '_') === 0) {
                    if ($this->confirm("Apply the $migration migration?")) {
                        if (!$this->migrateUp($migration)) {
                            echo "\nMigration failed.\n";

                            return self::EXIT_CODE_ERROR;
                        }
                        return self::EXIT_CODE_NORMAL;
                    }
                    return;
                }
            }
            throw new Exception("Unable to find the version '$limit'.");
        }
        return parent::actionUp($limit);
    }

    /**
     * @inheritdoc
     */
    public function actionDown($limit = 1)
    {
        if ($this->specialAction) {
            $version = $limit;
            if (preg_match('/^m?(\d{6}_\d{6})(_.*?)?$/', $version, $matches)) {
                $version = 'm' . $matches[1];
            } else {
                throw new Exception("The version argument must be either a timestamp (e.g. 101129_185401)\nor the full name of a migration (e.g. m101129_185401_create_user_table).");
            }

            $migrations = array_keys($this->getMigrationHistory(null));
            foreach ($migrations as $migration) {
                if (strpos($migration, $version . '_') === 0) {
                    if ($this->confirm("Revert the $migration migration?")) {
                        if (!$this->migrateDown($migration)) {
                            echo "\nMigration failed.\n";

                            return self::EXIT_CODE_ERROR;
                        }
                        return self::EXIT_CODE_NORMAL;
                    }
                    return;
                }
            }
            throw new Exception("Unable to find the version '$limit'.");
        }
        return parent::actionDown($limit);
    }

    /**
     * @inheritdoc
     */
    public function actionRedo($limit = 1)
    {
        if ($this->specialAction) {
            $version = $limit;
            if (preg_match('/^m?(\d{6}_\d{6})(_.*?)?$/', $version, $matches)) {
                $version = 'm' . $matches[1];
            } else {
                throw new Exception("The version argument must be either a timestamp (e.g. 101129_185401)\nor the full name of a migration (e.g. m101129_185401_create_user_table).");
            }

            $migrations = array_keys($this->getMigrationHistory(null));
            foreach ($migrations as $migration) {
                if (strpos($migration, $version . '_') === 0) {
                    if ($this->confirm("Revert the $migration migration?")) {
                        if (!$this->migrateDown($migration)) {
                            echo "\nMigration failed.\n";

                            return self::EXIT_CODE_ERROR;
                        }
                        if (!$this->migrateUp($migration)) {
                            echo "\nMigration failed.\n";

                            return self::EXIT_CODE_ERROR;
                        }
                        return self::EXIT_CODE_NORMAL;
                    }
                    return;
                }
            }
            throw new Exception("Unable to find the version '$limit'.");
        }
        return parent::actionDown($limit);
    }
}