<?php
/*
 * Title : Message Controller
 * Description : Manages all messages
 *
 */

class message
{
	public function get_messages($thread, $from_time);
	
	public function send($thread, $content);
	
	public function delete($message, $owner);
}
?>