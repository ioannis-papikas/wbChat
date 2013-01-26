<?php
// Require System Configuration
require_once("../../_config.php");

// Header Code
importer::importCore("profile::user");
importer::importCore("messages::thread");
importer::importCore("database::sqlQuery");
importer::importCore("database::dbConnection");
echo "running...";
// Get profile
$profile = user::profile();
if (is_null($profile))
	return;
	

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	echo "posting...";
	// Create new thread
	$recipients = array();
	$recipients[] = $_POST['recipient'];
	$status = thread::create($recipients, $_POST['subject'], $_POST['message']);
	
	echo "success: ".$status;
	return;
}
	
// Get users
$dbc = new dbConnection();
$dbq = new sqlQuery();

$dbq->set_query("SELECT * FROM user WHERE id != ".$profile['id']);
$result = $dbc->execute_query($dbq);

$recipients = array();
while ($rec = $dbc->fetch($result))
	$recipients[$rec['id']] = $rec['username'];

?>
<div id="chatControls">
	<h3>Δημιουργία Νέας Συζήτησης</h3>
	<form method="post">
		<div class="recipients">
			<span>To:</span>
			<select name="recipient">
			<?php
					foreach ($recipients as $key => $value)
						echo "<option value=\"".$key."\">".$value."</option>";
			?>
			</select>
		</div>
		<div class="textInput">
			<input type="text" name="subject" placeholder="Write your Subject here..." autofocus="autofocus"></input>
			<textarea id="threadMessage" name="message" placeholder="Write your Message here..."></textarea>
		</div>
		<div class="inputControls">
			<button id="newThread" type="submit" class="uiFormButton chat" >Send</button>
		</div>
	</form>
</div>