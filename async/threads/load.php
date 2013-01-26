<?php

// Require System Configuration
require_once("../../_config.php");

print_r($_GET);

// Import
importer::importCore("messages::thread");
importer::importCore("ui::threadItem");

// Get threads
$view = $_GET['view'];
$threads = thread::get_threads($view);

foreach ($threads as $thread)
{
	// Create new threadItem
	$threadItem = new threadItem($thread['id']);
	$threadItem->set_user($thread['recipient']);
	$threadItem->set_date($thread['date']);
	$threadItem->set_content($thread['subject'], $thread['snippet']);
	$threadHTML .= $threadItem->getHTML();
}
// Get Message Viewer Controller

?>
<div id="chatroom" class="chatroom">
	<div id="threadList" class="threadList">
		<?php echo $threadHTML; ?>
	</div>
	<div id="messageList" class="messageList"></div>
</div>
