<?php

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore("database::dbConnection");
importer::importCore("database::sqlquerycreator");
importer::importCore("database::sqlQuery");

/**
 *
 *
 * @author Marios
 */
abstract class Model {
    
    /**
     * @var dbConnection
     */
    private $dbc;
    
    /**
     * The name of the database table this class represents.
     * 
     * <p>Every subclass is expected to set its own value.</p>
     * 
     * @var string The name of the database table this class represents.
     */
    protected $table = '';
    
    /**
     * Returns the connection to the database.
     * 
     * @return DbConnection the connection to the database.
     */
    public function getDbConnection() {
        return $this->dbc;
    }
    
    /**
     * Creates a new Model.
     */
    protected function __construct() {
        $this->dbc = new dbConnection();
    }
}

?>
