<?php
require_once 'sql.php';
/**
 * Handles all interaction with MySQL DBMS.
 *
 * @author John
 * @author Marios
 */
class dbManager {
    
    private $db;
    
    /**
     * 
     * @throws UnexpectedValueException if the connection failed
     */
    public function __construct() {
        $this->db = new mysqli('redback.dyndns-at-home.com', 'jomar', 'fireboy', 'chatroom');
        if ($this->db->connect_errno) {
            throw new UnexpectedValueException($this->db->error);
        } 
        
    }
    
    public function getConnection(){
        return $this->db;
    }
}
?>