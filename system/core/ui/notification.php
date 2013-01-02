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
	private $holder;
	
	public function __construct($type = "")
	{
		// Initialize DOM Document
		DOM::initialize();
		
		// Create Notification Holder
		$this->holder = DOM::create("div", "", "", "notification".($type == "" ? "" : " $type"));
		DOM::append($this->holder);
	}
	
	public function set_header($title)
	{
		// Create Header
		$header = DOM::create("h4", $title, "", "header");
		DOM::append($this->holder, $header);
	}
	
	public function set_body($content)
	{
		// Create body
		$body = DOM::create("div", "", "", "body");
		DOM::append($this->holder, $body);
		
		// Insert Content
		DOM::append($body, $content);
	}
	
	public function getHTML()
	{
		return DOM::getHTML();
	}
}

?>