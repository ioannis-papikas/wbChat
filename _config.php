<?php
// Define Platform
define("_WBCHAT_PLATFORM_", TRUE);

// Constants Definition
//_____ Site Root
define("siteRoot", "/___projects/wbChat");

//_____ System Root
define("systemRoot", $_SERVER['DOCUMENT_ROOT']."/".siteRoot);

//_____ System Core Root
define("systemCore", systemRoot."/system/core");

//_____ System Resources Root
define("systemResources", "/resources");


// Require Importer
require_once(systemCore."/base/importer.php");

// Init Session
importer::importCore("state::session");
session::init();

?>