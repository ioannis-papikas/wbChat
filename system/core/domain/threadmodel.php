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
        $this->threadTypeId = 0;
        $this->subject = '';
        $this->dateCreated = null;
    }
    
    /**
     * @return string The date this Thread was created.
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }
    
    /**
     * @return string The subject of this Thread.
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * @return integer The ID of the Thread's type.
     */
    public function getThreadTypeId() {
        return $this->threadTypeId;
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
        /* Gather Thread's info. */
        $threadTypeModel = new ThreadTypeModel();
        $threadType = $threadTypeModel->findByDescription($threadDesc);
        if ($threadType === null) {
            throw new UnexpectedValueException(
                    'Unknown thread description: ' . $threadDesc);
        }

        $dateCreated = date('Y-m-d H:i:s', time());
        
        /* Store the newly created Thread's info to this Thread. */
        $this->setDateCreated($dateCreated);
        $this->setSubject($subject);
        $this->setThreadTypeId($threadType['id']);

        /* Save the Thread to the database. */
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
                    $dateCreated
                ));
        $dbc = new dbConnection();
        $dbc->execute_query(new sqlQuery($threadQuery));
        $dbLink = $dbc->getConnector()->getConnection();
        $threadId = mysqli_insert_id($dbLink);
        
        $threadRecipientsModel = new ThreadRecipientsModel();
        $threadRecipientsModel->saveAll($userIds, $threadId);
    }
    
    /**
     * 
     * @param string $dateCreated
     */
    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
    }
    
    /**
     * 
     * @param string $subject
     * @throws InvalidArgumentException if the subject is null
     */
    public function setSubject($subject) {
        if ($subject === null) {
            throw new InvalidArgumentException(
                    'Cannot set null subject.');
        }
        
        $this->subject = $subject;
    }
    
    /**
     * 
     * @param integer $threadTypeId
     * @throws InvalidArgumentException if the ID is not a positive integer
     */
    public function setThreadTypeId($threadTypeId) {
        if (!is_integer($threadTypeId)
                || ($threadTypeId <= 0)) {
            throw new InvalidArgumentException(
                    'The ID of the Thread type must be a positive integer.');
        }
        
        $this->threadTypeId = $threadTypeId;
    }
}

?>
