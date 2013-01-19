<?php

/*
 * Title : Thread Controller
 * Description : Manages all threads
 *
 */

// System Check
if (!defined("_WBCHAT_PLATFORM_"))
    throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore("database::dbConnection");
importer::importCore("database::sqlbuilder");
importer::importCore("database::sqlQuery");

class thread {

    public function get_threads();

    public function get_recipients($thread);

    public static function create($type, $subject, $recipients) {
        $dateCreated = date('Y-m-d H:i:s', time());

        /* Save the Thread to the database. */
        $sqc = new SqlBuilder();
        $threadQuery = $sqc->getInsertStatement('thread', 
                array('threadType_id', 'subject', 'dateCreated'), 
                array($type, $subject, $dateCreated));
        $dbc = new dbConnection();
        $dbc->execute_query(new sqlQuery($threadQuery));
        $dbLink = $dbc->getConnection();
        $threadId = mysqli_insert_id($dbLink);

        foreach ($recipients as $recipientId)
            self::add_recipient($threadId, $recipientId);
    }

    public function delete($thread);

    public function move($thread, $folder);

    public static function add_recipient($threadId, $recipientId) {
        if ($recipientId === null)
            throw new InvalidArgumentException('Recipient not given.');

        if (empty($threadId) || ($threadId < 0))
            throw new InvalidArgumentException(
                'Invalid thread ID: ' . $threadId);

        // Create SQL Query
        $sqc = new SqlBuilder();
        $query = $sqc->getInsertStatement('threadrecipients', 
                array('thread_id', 'recipient_id'), 
                array($threadId, $recipientId));

        // Set SQL Query Value
        $sq = new sqlQuery();
        $sq->set_query($query);

        // Execute Query
        $dbc = new dbConnection();
        $dbc->execute_query($sq, 0);
    }

    public function remove_recipient($thread, $recipient);

    public static function get_type($description) {
        if ($description === null)
            throw new InvalidArgumentException(
                'Cannot search for ThreadType with empty description.');

        $sqc = new SqlBuilder();
        $sqc->selectTableColumn('threadtype', 'id')
                ->from('threadtype')
                ->where('`description` = "' . $description . '"')
                ->createQuery();

        $threadType = NULL;

        // Set SQL Query Value
        $sq = new sqlQuery();
        $sq->set_query($sqc->getQuery());

        // Execute Query
        $dbc = new dbConnection();
        $resultSet = $dbc->execute_query($sq, 0);

        if ($resultSet)
            return $dbc->fetch($resultSet);

        return FALSE;
    }

    public function add_type($description);

    public function remove_type($type);

    public function add_folder($owner, $description);

    public function remove_folder($folder);
}

?>