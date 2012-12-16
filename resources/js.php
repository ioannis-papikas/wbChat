<?php
// Require System Configuration
require_once($_SERVER['DOCUMENT_ROOT']."/___projects/wbChat/_config.php");

ob_end_clean();
ob_start();
header('Content-type: text/javascript');
echo "/* WebChat Scripts Library */\n\n";

importer::importJS("jquery");
importer::importJS("chatroom");

?>
