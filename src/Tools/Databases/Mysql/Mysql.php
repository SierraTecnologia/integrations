<?php

namespace Integrations\Tools\Databases\Mysql;

use Integrations\Tools\Bash;

/**
 * Mysql Class
 *
 * @class Mysql
 */
class Mysql
{

    public static $TYPEID = 1;

    protected $local = false;
    protected $database = false;
    protected $collection = false;

    public function __construct($collection)
    {
        $this->local = new Bash();
        $this->database = $collection->database;
        $this->collection = $collection;
    }

    public function connect(): void
    {
        $this->local->exec('mysql '.$this->getConnectString($this->database->host, $this->database->user, $this->database->password, $this->collection->getName()));
    }

    public function getConnectString($databaseHost, $databaseUser, $password, $databaseName = false): string
    {
        $string = '-h '.$databaseHost.' -u '.$databaseUser.' -p'.$password;
        
        if ($databaseName) {
            $string .= ' '.$databaseName;
        }
        
        return $string;
    }

    public function backup(): void
    {

            /**
             * Instantiate Backup and perform backup
             */

            // Report all errors
            error_reporting(E_ALL);
            // Set script max execution time
            set_time_limit(900); // 15 minutes

        if (php_sapi_name() != "cli") {
            echo '<div style="font-family: monospace;">';
        }

            $backupDatabase = new Backup(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, CHARSET);
            $result = $backupDatabase->backupTables(TABLES, BACKUP_DIR) ? 'OK' : 'KO';
            $backupDatabase->obfPrint('Backup result: ' . $result, 1);

            // Use $output variable for further processing, for example to send it by email
            $output = $backupDatabase->getOutput();

        if (php_sapi_name() != "cli") {
            echo '</div>';
        }

    }

    public function restore(): void
    {

        /**
         * Instantiate Restore and perform backup
         */
        // Report all errors
        error_reporting(E_ALL);
        // Set script max execution time
        set_time_limit(900); // 15 minutes

        if (php_sapi_name() != "cli") {
            echo '<div style="font-family: monospace;">';
        }

        $restoreDatabase = new Restore(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $result = $restoreDatabase->restoreDb(BACKUP_DIR, BACKUP_FILE) ? 'OK' : 'KO';
        $restoreDatabase->obfPrint("Restoration result: ".$result, 1);

        if (php_sapi_name() != "cli") {
            echo '</div>';
        }



    }

    public function export($fileName = false)
    {
        if (!$fileName) {
            $fileName = $this->collection->getName().time();
        }
        $connectString = $this->getConnectString($this->database->host, $this->database->user, $this->database->password, $this->collection->getName());
        // Caso Tenha Instalado na Maquina!
        // if ($this->local->hasProgram('mysqldump')){
        //     return $this->local->exec('mysqldump '.$connectString.' > '.$fileName.'.sql');
        // }
        return (new \Integrations\Tools\Docker\Mysql\Program())->singleBackup($connectString);
    }

    public function import($fileName): void
    {
        $this->local->exec('mysql '.$this->getConnectString($this->database->host, $this->database->user, $this->database->password, $this->collection->getName()).' < '.$fileName.'.sql');
    }

    /**
     * @return string[]
     *
     * @psalm-return non-empty-list<string>
     */
    public function getTables(): array
    {
        /**
         * +-----------------------+
         * | Tables_in_pizza_store |
         * +-----------------------+
         * | crust_sizes            * | 
         * | crust_types            * | 
         * | customers              * | 
         * | orders                 * | 
         * | pizza_toppings         * | 
         * | pizzas                 * | 
         * | toppings               * | 
        * +-----------------------+
         */
        $result = explode('+', $this->exec('show tables'))[3];

        $tables = explode('|', $result);
        foreach($tables as $indice=>$table) {
            $tables[$indice] = trim($table);
        }
        return $tables;
    }

    public function getFields($tableName): void
    {
        $this->exec('DESCRIBE '.$tableName);
    }

    /**
     * @return true
     */
    public function mergeFrom($database): bool
    {
        $tables = $this->getTables();

        foreach($tables as $table) {
            $this->exec('INSERT INTO '.$this->collection->getName().'.'.$table.' SELECT * FROM DB2.'.$database->collection->getName());
        }

        return true;
    }
}
