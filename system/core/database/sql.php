<?php
/*
 * Title : SQL Creator
 * Description : Creates SQL queries
 *
 */

class SqlQueryCreator {
    
    public function select(array $tblColsMap = array()) {
        
      $stmt = empty($tblColsMap) ? 'SELECT *' : 'SELECT '; 
      
      $tblColPairs = array();
      foreach ($tblColsMap as $tableName => $cols) {
          foreach ($cols as $columnName) {
              $tblColPairs[] = '`' . $tableName . '`' . '.`' . $columnName . '`';
          }
      }
      $stmt .= implode(',' , $tblColPairs);
      return $stmt;
    }
}
?>