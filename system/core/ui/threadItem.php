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
	
	public function __construct($threadID)
	{
		// Initialize DOM Document
		$this->dom = new DOM();
		
		// Create Notification Holder
		$this->holder = $this->dom->create("div", "", "", "thread");
		$this->dom->attr($this->holder, "data-tid", $threadID);
		$this->dom->append($this->holder);
	}
	
	public function set_user($user)
	{
		// Create Header
		$header = $this->dom->create("div", $user, "", "userName");
		$this->dom->append($this->holder, $header);
	}
	public function set_date($date)
	{
		// Create Header
		$dateHolder = $this->dom->create("div", $date, "", "threadDate");
		$this->dom->append($this->holder, $dateHolder);
	}
	
	public function set_content($subject, $snippet)
	{
		// Create threadContent
		$content = $this->dom->create("div", "", "", "threadContent");
		$this->dom->append($this->holder, $content);
		
		// Content Subject
		$subjectElement = $this->dom->create("span", $subject, "", "threadSubject");
		$this->dom->append($content, $subjectElement);
		
		// Content Snippet
		$snippetElement = $this->dom->create("div", $snippet, "", "threadSnippet");
		$this->dom->append($content, $snippetElement);
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