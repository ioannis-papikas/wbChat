<?php

require_once systemCore . '/database/dbmanager.php';

/**
 * Description of User
 *
 * @author Marios
 */
class User {

    public static function getUsers() {
        $sqc = new SqlQueryCreator();
        $sqc->selectTableColumns('user', array('id', 'username'), array('', ''))
            ->from('user')
            ->createQuery();
        $dbm = dbManager::getInstance();
        
        return $dbm->submitQuery($sqc->getQuery());
    }
    
}

?>
