<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of thread
 *
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
     * 
     * @param string $threadType
     * @param string $subject
     * @param array $userIds
     * @throws UnexpectedValueException if the thread type specified is unknown.
     */
    public function saveNew($threadType, $subject, $userIds) {
        $threadTypeId = $this->getThreadTypeId($threadType);
        if ($threadTypeId === 0) {
            throw new UnexpectedValueException(
                    'Unknown thread type: ' . $threadType);
        }

        $sqc = new SqlQueryCreator();
        $query = $sqc->getInsertQuery('threadtype', array(
            'NULL', $threadTypeId, $subject, date('Y-m-d H:i:s', time())
        ));
        
        $dbc = new dbConnection();
        $dbc->execute_query($query);
        $dbLink = $dbc->getConnector()->getConnection();
        $threadId = mysqli_insert_id($dbLink);
        
        $this->saveUsers($userIds, $threadId);
    }

    /**
     * 
     * @param string $threadType
     * @return int The ID of the specified thread type or zero (0) if no such
     * type exists.
     */
    private function getThreadTypeId($threadType) {
        $sqc = new SqlQueryCreator();
        $sqc->selectTableColumn('threadtype', 'id')
                ->from('threadtype')
                ->where('description = ' . $threadType)
                ->createQuery();

        $dbc = new dbConnection();
        $result = $dbc->execute_query($sqc->getQuery(), 0);
        if ($result) {
            $row = $row = $result->fetchAssoc();
            if ($row) {
                return $row['id'];
            }
        }

        return 0;
    }

    private function saveUsers($userIds, $threadId) {
        foreach ($userIds as $userId) {
            $sqc = new SqlQueryCreator();
            $query = $sqc->getInsertQuery('threadrecipients', array(
                $threadId, $userId));

            $dbc = new dbConnection();
            $dbc->execute_query($query, 0);
        }
    }

}

?>
