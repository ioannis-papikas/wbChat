<?php

// Require System Configuration
require_once("../../_config.php");

importer::importCore("messages::message");
importer::importCore("ui::messageList");


$threadID = $_GET['tid'];
$messages = message::get_messages($threadID);
// Get Message Viewer Controller

// Build messageList
$messageList = new messageList();

$lastAuthor = NULL;
foreach ($messages as $message)
{
	if ($message['author'] != $lastAuthor)
	{
		$lastAuthor = $message['author'];
		$messageList->add_message($message['author'], $message['date'], $message['content']);
	}
	else
		$messageList->append_message($message['date'], $message['content']);
}

echo $messageList->getHTML();
?>
<form method="post">
	<?php
		// Set Hidden threadid
		echo "<input name=\"tid\" type=\"hidden\" value=\"".$threadID."\" />";
	?>
	<div id="chatControls">
		<div class="textInput">
			<textarea id="threadMessage" name="message" placeholder="Write your message here..." autofocus="autofocus"></textarea>
		</div>
		<div class="inputControls">
			<button id="sendMessage" type="button" class="uiFormButton chat" >Send</button>
		</div>
	</div>
</form>
