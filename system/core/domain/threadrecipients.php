<?php

importer::importCore('domain::model');

/**
 * 
 *
 * @author John
 * @author Tasos
 */
class ThreadRecipientsModel extends Model {
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'threadrecipients';
    }
    
    /**
     * Saves all the recipients of the Thread with the specified ID.
     * 
     * @param array $recipientIds
     * @param integer $threadId
     * @throws InvalidArgumentException if the recipients array is null or the
     * thread ID is empty (in the PHP sense) or negative
     */
    public function saveAll($recipientIds, $threadId) {
        if ($recipientIds === null) {
            throw new InvalidArgumentException(
                    'List of recipients is null.');
        }
        
        if (empty($threadId)
                || ($threadId < 0)) {
            throw new InvalidArgumentException(
                    'Invalid thread ID: ' . $threadId);
        }
        
        $dbc = $this->getDbConnection();
        foreach ($recipientIds as $recipientId) {
            $sqc = new SqlBuilder();
            $query = $sqc->getInsertStatement($this->table, array(
                $threadId, $recipientId));

            $dbc->execute_query(new sqlQuery($query), 0);
        }
    }
}

?>
