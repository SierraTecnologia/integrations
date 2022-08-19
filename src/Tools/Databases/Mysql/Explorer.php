<?php
/**
 * Inspiração: https://github.com/heathbm/MySQL-Explorer/blob/master/php/scripts.php
 */

namespace Integrations\Tools\Databases\Mysql;

use Integrations\Tools\Bash;

/**
 * Explorer Class using Mysqli
 *
 * @class Explorer
 */
class Explorer
{

    /**
     * @return \mysqli|null
     */
    function login($loginParams)
    {
        $connection = @mysqli_connect($loginParams['svr'], $loginParams['name'], $loginParams['psw'])
        or die("<p>initial host/db connection problem</p>"."<br/><br/><button type='button' id='nav' onclick='retry()'>Try again</button>"); //button runs logout so user can return to login screen
        if(errorCheck($connection)) {
            return $connection;
        }
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

    function load_db($first): void
    {
        if($first) {
            setDbSession();
        }
        echo "<button type='button' id='nav' onclick='reloadDB()'>RETURN TO DATABASES</button>";
        $connection = login(getSession());
        $db = getDbSession();
        mysqli_select_db($connection, $db);
        $result = mysqli_query($connection, "show tables");  // run the query and assign the result to $result
        if (!$result) {
            echo 'MySQL Error: ' . mysqli_error();
            exit();
        }
        while($table = mysqli_fetch_array($result)) { // go through each row that was returned in $result
            echo "<button type='button' onclick='loadTable(&quot;" . $table[0] . "&quot;)'>" . $table[0]  . "</button>";
            echo "<br>";    // print the table that was returned on that row.
        }
    }



    function getDatabases($first): void
    {
        if($first) {
            setSession();
        }
        $connection = login(getSession());
        $result = mysqli_query($connection, "SHOW DATABASES");
        $available = array();
        $index = 0;
        echo "<button type='button' id='nav' onclick='logout()'>LOGOUT</button>";
        while( $row = mysqli_fetch_row($result) ){
            if (($row[0]!="information_schema") && ($row[0]!="mysql")) {
                $index += 1;
                echo "<button type='button' onclick='loadDB(&quot;" . $row[0] . "&quot;)'>" . $row[0] . "</button>";
                echo "<br>";
            }
        }
    }



    function loadTable(): void
    {
        $connection = login(getSession());
        $db = getDbSession();
        mysqli_select_db($connection, $db);
        setTableSession();
        $table = getTableSession();
        echo "<button type='button' id='nav' onclick='reloadTables()'>RETURN TO TABLES</button>";
        $query = "SELECT * FROM " . $table;
        $result1 = mysqli_query($connection, $query) or die(mysqli_error($connection));
        //iterate over all the rows
        $collumns = 0;
        $index = 0;
        $data = array();
        echo "<table id='data' ><tr>";
        $fields = mysqli_query($connection, "SHOW columns FROM " . $table);
        while($row = mysqli_fetch_array($fields)) {
            echo "<th>" . $row["Field"] . "</th>";
            $collumns += 1;
        }
        echo "</tr>";
        while($row = mysqli_fetch_assoc($result1)) {  //iterate over all the fields
            foreach($row as $key => $val){  //generate output
                $data[$index] = $val;
                $index += 1;
            }
        }
        $subIndex = 0;
        for($i = 0; $i < count($data);) {
            echo "<tr>";
            for($j = 0; $j < $collumns; $j++) {
                echo "<td>";
                echo $data[$subIndex];
                $subIndex += 1;
                $i++;
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

}
