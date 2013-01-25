<?php
/*
 * Title : User Controller
 * Description : Manages user profile
 *
 */

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore("base::DOM");

class threadItem
{
	private $dom;
	private $holder;
	
	public function __construct()
	{
		// Initialize DOM Document
		$this->dom = new DOM();
		
		// Create Notification Holder
		$this->holder = $this->dom->create("div", "", "", "thread");
		$this->dom->append($this->holder);
	}
	
	public function set_thread($thread)
	{
		// Create Header
		$header = $this->dom->create("h4", $title, "", "header");
		$this->dom->append($this->holder, $header);
	}
	
	public function getDOM()
	{
		return $this->dom;
	}
	
	public function getHTML()
	{
		return $this->dom->getHTML();
	}
}

?>