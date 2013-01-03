<?php

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore("database::dbConnection");

/**
 * Description of User
 *
 * @author Marios
 */
class UserModel {

    /**
     * Retrieves all the Users from the database.
     * 
     * @return mixed false on failure; a {@link mysqli_result}, otherwise
     */
    public static function getUsers() {
        $sqc = new SqlBuilder();
        $sqc->selectTableColumns('user', array('id', 'username'), array('', ''))
            ->from('user')
            ->createQuery();
        $dbc = new dbConnection();
        
        return $dbc->execute_query($sqc->getQuery());
    }
    
}

?>
