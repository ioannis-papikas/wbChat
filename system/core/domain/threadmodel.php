<?php

//require_once systemCore . '/database/sqlquerycreator.php';
//require_once systemCore . '/database/dbConnection.php';
//require_once systemCore . '/database/sqlQuery.php';

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore("domain::model");
importer::importCore('domain::threadtypemodel');
importer::importCore('domain::threadrecipientsmodel');

/**
 * Description of thread
 *
 * @author John
 * @author Marios
 */
class ThreadModel extends Model {
    
    private $dateCreated;
    private $subject;
    private $threadTypeId;

    public function __construct() {
        parent::__construct();
        $this->table = 'thread';
        
        $this->threadTypeId = 0;
        $this->subject = '';
        $this->dateCreated = null;
    }

    /**
     * Saves a new User.
     * 
     * @param string $threadDesc
     * @param string $subject
     * @param array $userIds
     * @throws UnexpectedValueException if the thread description specified is unknown.
     */
    public function saveNew($threadDesc, $subject, $userIds) {
        $threadTypeModel = new ThreadTypeModel();
        $threadType = $threadTypeModel->findByDescription($threadDesc);
        if ($threadType === null) {
            throw new UnexpectedValueException(
                    'Unknown thread description: ' . $threadDesc);
        }

        $sqc = new SqlQueryCreator();
        $threadQuery = $sqc->getInsertQuery($this->table, array(
            'NULL', $threadType['id'], $subject, date('Y-m-d H:i:s', time())
        ));
        $dbc = $this->getDbConnection();
        $dbc->execute_query($threadQuery);
        $dbLink = $dbc->getConnector()->getConnection();
        $threadId = mysqli_insert_id($dbLink);
        
        $threadRecipientsModel = new ThreadRecipientsModel();
        $threadRecipientsModel->saveAll($userIds, $threadId);
    }
}

?>
