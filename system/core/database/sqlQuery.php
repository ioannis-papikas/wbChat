<?php

/*
 * Title : SQL Creator
 * Description : Creates SQL queries
 *
 */

class sqlQuery {

    private $query;
    
    public function set_query($query) {
        $this->query = $query;
    }

    public function get_query() {
        return $this->query;
    }

}

?>