<?php
/*
 * Title : Thread Controller
 * Description : Manages all threads
 *
 */

class thread
{
	public function get_threads();
	
	public function get_recipients($thread);
	
	public function create($type, $subject);
	
	public function delete($thread);
	
	public function move($thread, $folder);
	
	public function add_recipient($thread, $recipient);
	
	public function remove_recipient($thread, $recipient);
	
	public function add_type($description);
	
	public function remove_type($type);
	
	public function add_folder($owner, $description);
	
	public function remove_folder($folder);
}
?>