<?php

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore("database::dbConnection");
importer::importCore("database::sqlbuilder");
importer::importCore("database::sqlQuery");
importer::importCore('domain::threadtypemodel');
importer::importCore('domain::threadrecipientsmodel');

/**
 * Description of thread
 *
 * @author John
 * @author Marios
 */
class ThreadModel {
    
    private $dateCreated;
    private $subject;
    private $threadTypeId;

    public function __construct() {
        parent::__construct();
        
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

        $sqc = new SqlBuilder();
        $threadQuery = $sqc->getInsertStatement('thread', 
                array(
                    'id',
                    'threadType_id',
                    'subject',
                    'dateCreated'
                ), array(
                    'NULL',
                    $threadType['id'], 
                    $subject, 
                    date('Y-m-d H:i:s', time())
                ));
        $dbc = new dbConnection();
        $dbc->execute_query(new sqlQuery($threadQuery));
        $dbLink = $dbc->getConnector()->getConnection();
        $threadId = mysqli_insert_id($dbLink);
        
        $threadRecipientsModel = new ThreadRecipientsModel();
        $threadRecipientsModel->saveAll($userIds, $threadId);
    }
}

?>
