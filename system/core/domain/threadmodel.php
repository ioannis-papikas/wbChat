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
        $this->dateCreated = date('Y-m-d H:i:s', time());
    }
}

?>
