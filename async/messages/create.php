<?php
// Require System Configuration
require_once("../../_config.php");

// Header Code
importer::importCore('domain::threadmodel');
importer::importCore('view::threadview');

$threadView = new ThreadView();
echo $threadView->display();

?>
<script src="<?php echo siteRoot . systemResources; ?>/scripts/chatroom-create.js"></script>'