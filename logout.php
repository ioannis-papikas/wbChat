<?php
// Require System Configuration
require_once("_config.php");

// Import System Classes
importer::importCore("profile::user");

// Logout user
user::logout();

// Redirect to index
header('Location: index.php');
return;

?>
