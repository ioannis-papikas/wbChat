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

class notification
{
	private $dom;
	private $holder;
	
	public function __construct($type = "")
	{
		// Initialize DOM Document
		$this->dom = new DOM();
		
		// Create Notification Holder
		$this->holder = $this->dom->create("div", "", "", "notification".($type == "" ? "" : " $type"));
		$this->dom->append($this->holder);
	}
	
	public function set_header($title)
	{
		// Create Header
		$header = $this->dom->create("h4", $title, "", "header");
		$this->dom->append($this->holder, $header);
	}
	
	public function set_body($content)
	{
		// Create body
		$body = $this->dom->create("div", "", "", "body");
		$this->dom->append($this->holder, $body);
		
		// Insert Content
		$this->dom->append($body, $content);
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