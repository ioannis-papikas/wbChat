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
 * @author Tasos
 */
class ThreadRecipientsModel {
    
    /**
     * 
     */
    public function __construct() {
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
        
        $dbc = new dbConnection();
        foreach ($recipientIds as $recipientId) {
            $sqc = new SqlBuilder();
            $query = $sqc->getInsertStatement('threadrecipients',
                    array(
                        'thread_id',
                        'recipient_id'
                    ), array(
                        $threadId, 
                        $recipientId
                    ));

            $dbc->execute_query(new sqlQuery($query), 0);
        }
    }
}

?>
