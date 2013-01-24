<?php

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore("database::dbConnection");
importer::importCore("database::sqlbuilder");
importer::importCore("database::sqlQuery");

/**
 * 
 *
 * @author John
 * @author Marios
 */
class ThreadTypeModel {
    
    /**
     * 
     */
    public function __construct() {
    }
    
    /**
     * Returns the ThreadType with the specified description.
     * 
     * @param string $description
     * @return array|null The row of the database of the ThreadType with the specified
     * description or null if no such ThreadType exists.
     * @throws InvalidArgumentException if the description is null
     */
    public function findByDescription($description) {
        if ($description === null) {
            throw new InvalidArgumentException(
                    'Cannot search for ThreadType with empty description.');
        }
        
        $dbc = new dbConnection();
        $description = $dbc->clear_resource($description);
        $sqc = new SqlBuilder();
        $sqc->selectTableColumn('threadtype', 'id')
                ->from('threadtype')
                ->where('`description` = "' . $description . '"')
                ->createQuery();

        $sqlQuery = new sqlQuery();
        $sqlQuery->set_query($sqc->getQuery());
        $resultSet = $dbc->execute_query($sqlQuery);
        if ($resultSet) {
            return $dbc->fetch($resultSet);
        }

        return null;
    }
}

?>
