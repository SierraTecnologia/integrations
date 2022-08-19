<?php

namespace Integrations\Tools\Docker\Mysql;

use Integrations\Tools\Bash;

/**
 * Program Class
 *
 * @class Program
 */
class Program
{

    protected $dockerFile = false;

    protected $local = false;

    protected $env = [];

    public function __construct($bash = false, $dockerFile = false)
    {
        $this->local = $bash;
        if (!$this->local) {
            $this->local = new Bash();
        }

        if (!$this->dockerFile) {
            $this->dockerFile = dirname(__FILE__).'/Dockerfile';
        }
    }

    public function generateEnvFromCollection($collection)
    {
        $this->env['MYSQL_HOST'] = $collection->db;
        $this->env['MYSQL_USER'] = $collection->user;
        $this->env['MYSQL_PASSWORD'] = $collection->password;
        $this->env['MYSQL_DATABASE'] = $collection->database;
        return $this->env;
    }



    public function singleBackup(string $connectString)
    {
        $dockerRunCode = 'docker run \\'.
        '--rm --entrypoint "" \\'.
        '-v `pwd`/backup:/backup \\'.
        '--link="container:alias" \\'.
        'schnitzler/mysqldump \\'.
        'mysqldump --opt '.$connectString;
        var_dump($dockerRunCode); 
        return $this->local->exec($dockerRunCode, true);
    }
}
