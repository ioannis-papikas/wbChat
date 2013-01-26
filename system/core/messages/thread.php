<?php

/*
 * Title : Thread Controller
 * Description : Manages all threads
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

class thread {

	/*
	 * Return all user's threads in a given model:
	 *
	 * [id] = threadid
	 * [subject] = thread subject
	 * [recipient] = thread recipient
	 * [snippet] = thread's last message body
	 */
    public static function get_threads($type = "all")
	{
		// Get User profile
		$profile = user::profile();
		
		$threadArray = array();
		$query = "SELECT
					thread.*,
					userThread.read,
					message.content as lastMessage,
					message.dateCreated as lastMessageDate,
					user.username as recipient
				FROM thread
				INNER JOIN userThread ON userThread.thread_id = thread.id
				INNER JOIN message ON message.thread_id = thread.id
				INNER JOIN userMessage ON userMessage.message_id = message.id
				INNER JOIN threadRecipients ON threadRecipients.thread_id = thread.id
				INNER JOIN user ON user.id = threadRecipients.recipient_id
				WHERE userThread.user_id = ".$profile['id']."
				AND userMessage.owner_id = ".$profile['id']."
				GROUP BY thread.id
				ORDER BY message.dateCreated DESC";
		
		// Set SQL Query Value
		$sq = new sqlQuery();
		$sq->set_query($query);

		// Execute Query
		$dbc = new dbConnection();
		$result = $dbc->execute_query($sq);
		
		while ($thr = $dbc->fetch($result))
		{
			$threadObj = array();
			$threadObj['id'] = $thr['id'];
			$threadObj['subject'] = $thr['subject'];
			$threadObj['read'] = $thr['read'];
			$threadObj['snippet'] = $thr['lastMessage'];
			$threadObj['date'] = $thr['lastMessageDate'];
			$threadObj['recipient'] = $thr['recipient'];
			
			$threadArray[] = $threadObj;
		}
		
		return $threadArray;
	}

    public static function get_recipients($threadID)
	{
		// Initialize Objects
		$dbc = new dbConnection();
		$dbq = new sqlQuery();
		
		$dbq->set_query("SELECT * FROM threadRecipients WHERE thread_id = ".$threadID);
		$result = $dbc->execute_query($dbq, $isTransaction = 1);
		
		$rec = array();
		while ($row = $dbc->fetch($result))
			$rec[] = $row['recipient_id'];
		
		return $rec;
	}

    public static function create($recipients, $subject, $message) {
		
		// Get User Profile
		$profile = user::profile();
		
		// Initialize Objects
		$dbc = new dbConnection();
		$dbq = new sqlQuery();
		
		// Create SQL Query
		$query = "";
		
		// _____ Create Thread
		date_default_timezone_set("UTC");
		$dateCreated = date('Y-m-d H:i:s', time());
		$query .= "INSERT INTO thread (subject, dateCreated) VALUES ('".$subject."', '".$dateCreated."');";
		$query .= "SELECT LAST_INSERT_ID() INTO @threadID;";
		
		// _____ Insert all recipients
		foreach ($recipients as $recID)
			$query .= "INSERT INTO threadRecipients (thread_id, recipient_id) VALUES (@threadID, ".$recID.");";
		
		// _____ Insert ME as recipient
		$query .= "INSERT INTO threadRecipients (thread_id, recipient_id) VALUES (@threadID, ".$profile['id'].");";
		
		// _____ Copy Thread for every recipient
		// _____ For ME
		$query .= "INSERT INTO userThread (thread_id, user_id, `read`) VALUES (@threadID, ".$profile['id'].", 1);";
		foreach ($recipients as $recID)
			$query .= "INSERT INTO userThread (thread_id, user_id, `read`) VALUES (@threadID, ".$recID.", 0);";
			
		// _____ Create Message
		$query .= "INSERT INTO message (thread_id, author_id, content, dateCreated) VALUES (@threadID, ".$profile['id'].", '".$message."', '".$dateCreated."');";
		$query .= "SELECT LAST_INSERT_ID() INTO @messageID;";
		
		// _____ Copy Message for every recipient
		// _____ For ME
		$query .= "INSERT INTO userMessage (message_id, owner_id, `read`) VALUES (@messageID, ".$profile['id'].", 1);";
		foreach ($recipients as $recID)
			$query .= "INSERT INTO userMessage (message_id, owner_id, `read`) VALUES (@messageID, ".$recID.", 0);";
			
		// Execute Query
		$dbq->set_query($query);
		$result = $dbc->execute_query($dbq, $isTransaction = 1);
		
		return $result;
    }

    public function delete($thread)
	{
	}

    public static function get_type($description) {
        if ($description === null)
            throw new InvalidArgumentException(
                'Cannot search for ThreadType with empty description.');

        $sqc = new SqlBuilder();
        $sqc->selectTableColumn('threadtype', 'id')
                ->from('threadtype')
                ->where('`description` = "' . $description . '"')
                ->createQuery();

        $threadType = NULL;

        // Set SQL Query Value
        $sq = new sqlQuery();
        $sq->set_query($sqc->getQuery());

        // Execute Query
        $dbc = new dbConnection();
        $resultSet = $dbc->execute_query($sq, 0);

        if ($resultSet)
            return $dbc->fetch($resultSet);

        return FALSE;
    }
}

?>