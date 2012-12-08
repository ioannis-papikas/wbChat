<?php
require_once 'sql.php';
/**
 * Handles all interaction with MySQL DBMS.
 *
 * @author John
 * @author Marios
 */
class dbManager {
    
    private $dbConnection;
    
    public function __construct() {
        $this->dbConnection = mysql_connect('redback.dyndns-at-home.com', 'jomar', 'fireboy')
                or die(mysql_error());
        
    }
    
    public function getConnection(){
        return $this->dbConnection;
    }
}
?>