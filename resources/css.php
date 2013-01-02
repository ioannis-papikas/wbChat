<?php
// Require System Configuration
require_once($_SERVER['DOCUMENT_ROOT']."/___projects/wbChat/_config.php");

ob_end_clean();
ob_start();
header('Content-type: text/css');
echo "@charset \"UTF-8\";\n";
echo "/* CSS Document */\n";
echo "/* Global Styles */\n\n";

importer::importCSS("chatroom");
importer::importCSS("main");
importer::importCSS("forms");
importer::importCSS("ui");

?>