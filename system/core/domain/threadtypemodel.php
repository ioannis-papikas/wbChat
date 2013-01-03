<?php

// Imports
importer::importCore("domain::model");

/**
 * 
 *
 * @author John
 * @author Marios
 */
class ThreadTypeModel extends Model {
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'threadtype';
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
        
        $sqc = new SqlBuilder();
        $sqc->selectTableColumn($this->table, 'id')
                ->from($this->table)
                ->where('`description` = "' . $description . '"')
                ->createQuery();

        $threadType = null;
        $resultSet = $this->getDbConnection()->execute_query(new sqlQuery($sqc->getQuery()));
        if ($resultSet) {
            $threadType = $resultSet->fetchAssoc();
        }

        return $threadType;
    }
}

?>
