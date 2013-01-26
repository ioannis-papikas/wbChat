<?php
// Require System Configuration
require_once("../../_config.php");

// Header Code
importer::importCore("messages::message");
importer::importCore("database::sqlQuery");
importer::importCore("database::dbConnection");

// Get profile
$profile = user::profile();
if (is_null($profile))
	return;

// Send Message
message::send($_POST['tid'], $_POST['message']);

?>