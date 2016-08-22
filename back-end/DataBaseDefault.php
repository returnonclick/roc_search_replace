<?php
/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 23/06/2016
 * Time: 4:43 PM
 * Mysql database class - only one connection alowed
*/

require_once ('ConfigDB.php');

class DataBase {
    private         $_connection;
    private static  $_instance;                             //The single instance
    private         $_host          = ConfigDB::HOST;
    private         $_username      = ConfigDB::USERNAME;
    private         $_password      = ConfigDB::PASSWORD;
    private         $_database      = ConfigDB::DB_DEFAULT;
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance() {
        if(!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    // Constructor
    private function __construct() {
        $this->_connection = new mysqli($this->_host, $this->_username,
            $this->_password, $this->_database);

        // Error handling
        if(mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
                E_USER_ERROR);
        }
    }
    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }
    // Get mysqli connection
    public function getConnection() {
        return $this->_connection;
    }
    
    public static function execute($sql) {
        // Change this line to reflect whatever Database system you are using:
        $result = self::getInstance() -> getConnection() -> query($sql);
        self::getInstance() -> checkErrors($sql);
        return $result;
    }
    public static function returnLast() {
        $result = mysqli_insert_id(self::getInstance() ->getConnection());
        return $result;
    }
    public static function nextRow ($result) {
        // Change this line to reflect whatever Database system you are using:
        $row = mysqli_fetch_array($result);
        return $row;
    }

    function checkErrors($sql) {

        //global $systemLog;

        // Only thing that we need todo is define some variables
        // And ask from RDBMS, if there was some sort of errors.
        $err=mysqli_error( self::getInstance() ->getConnection() );
        $errno=mysqli_errno( self::getInstance() ->getConnection() );

        if($errno) {
            // SQL Error occurred. This is FATAL error. Error message and
            // SQL command will be logged and aplication will teminate immediately.
            $message = "The following SQL command ".$sql." caused Database error: ".$err.".";

            //$message = addslashes("SQL-command: ".$sql." error-message: ".$message);
            //$systemLog->writeSystemSqlError ("SQL Error occurred", $errno, $message);

            print "Unrecowerable error has occurred. All data will be logged.";
            print "Please contact System Administrator for help! \n";
            print "<!-- ".$message." -->\n";
            exit;

        } else {
            // Since there was no error, we can safely return to main program.
            return;
        }
    }

}
?>