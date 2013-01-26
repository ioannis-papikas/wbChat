<?php
/*
 * Title : Message Controller
 * Description : Manages all messages
 *
 */

// System Check
if (!defined("_WBCHAT_PLATFORM_"))
    throw new Exception("Web Platform is not defined!");

// Imports
importer::importCore("database::dbConnection");
importer::importCore("database::sqlbuilder");
importer::importCore("database::sqlQuery");
importer::importCore("profile::user");
importer::importCore("messages::thread");

class message
{
	public static function get_messages($threadID, $limit = 50)
	{
		// Get User profile
		$profile = user::profile();
		
		$messageArray = array();
		$query = "SELECT message.*, user.username as author, userMessage.read
					FROM message
					INNER JOIN userMessage ON userMessage.message_id = message.id
					INNER JOIN user ON user.id = message.author_id
					WHERE userMessage.owner_id = ".$profile['id']."
					AND message.thread_id = ".$threadID."
					ORDER BY message.dateCreated ASC
					LIMIT ".$limit;

		// Set SQL Query Value
		$sq = new sqlQuery();
		$sq->set_query($query);

		// Execute Query
		$dbc = new dbConnection();
		$result = $dbc->execute_query($sq);
		
		while ($msg = $dbc->fetch($result))
		{
			$msgObj = array();
			$msgObj['id'] = $msg['id'];
			$msgObj['content'] = $msg['content'];
			$msgObj['read'] = $msg['read'];
			$msgObj['author'] = $msg['author'];
			$msgObj['date'] = $msg['dateCreated'];
			
			$messageArray[] = $msgObj;
		}
		
		return $messageArray;
	}
	
	public static function send($threadID, $message)
	{
		// Get User profile
		$profile = user::profile();
		
		// Get Thread recipients
		$recipients = thread::get_recipients($threadID);

		// Create Query
		$query = "";
		
		// _____ Create new message
		date_default_timezone_set("UTC");
		$dateCreated = date('Y-m-d H:i:s', time());	
		
		// _____ Create Message
		$query .= "INSERT INTO message (thread_id, author_id, content, dateCreated) VALUES (".$threadID.", ".$profile['id'].", '".$message."', '".$dateCreated."');";
		$query .= "SELECT LAST_INSERT_ID() INTO @messageID;";
		
		// _____ Copy Message for every recipient
		foreach ($recipients as $recID)
			$query .= "INSERT INTO userMessage (message_id, owner_id, `read`) VALUES (@messageID, ".$recID.", ".($recID == $profile['id'] ? "1" : "0").");";

		// Set SQL Query Value
		$sq = new sqlQuery();
		$sq->set_query($query);

		// Execute Query
		$dbc = new dbConnection();
		$result = $dbc->execute_query($sq, $isTransaction = 1);
	}
	
	public function delete($message, $owner)
	{
	}
}
?>