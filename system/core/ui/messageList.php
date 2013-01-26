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

class messageList
{
	private $dom;
	private $holder;
	private $lastMessageGroup;
	
	public function __construct()
	{
		// Initialize DOM Document
		$this->dom = new DOM();
		
		// Create Notification Holder
		$this->holder = $this->dom->create("div", "", "", "messages");
		$this->dom->append($this->holder);
	}
	
	public function add_message($author, $date, $content)
	{
		// Create Group
		$this->lastMessageGroup = $this->dom->create("div", "", "", "messageGroup");
		$this->dom->append($this->holder, $this->lastMessageGroup);
		
		// Create author div
		$authorDiv = $this->dom->create("div", $author, "", "author");
		$this->dom->append($this->lastMessageGroup, $authorDiv);
		
		// Append the message
		$this->append_message($date, $content);
	}
	
	public function append_message($date, $content)
	{
		// Create message
		$messageDiv = $this->dom->create("div", "", "", "message");
		
		$messageContent = $this->dom->create("div", "", "", "msgContent");
		$this->dom->append($messageDiv, $messageContent);
		
		$msgSpan = $this->dom->create("span", $content);
		$this->dom->append($messageContent, $msgSpan);
		
		$messageTime = $this->dom->create("div", "", "", "msgTime");
		$this->dom->append($messageDiv, $messageTime);
		
		$timeSpan = $this->dom->create("abbr", $date);
		$this->dom->attr($timeSpan, "title", $date);
		$this->dom->append($messageTime, $timeSpan);
		
		// Append message to last group
		$this->dom->append($this->lastMessageGroup, $messageDiv);
		
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