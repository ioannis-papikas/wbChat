<?php

// Require System Configuration
require_once("_config.php");

require_once systemCore . '/domain/threadmodel.php';
$thread = new ThreadModel();
$thread->saveNew('test', 'Example subject.', array(1, 2));

?>
<!DOCTYPE>
<html>
<?php importer::includeResource("head"); ?>
<body>
	<?php importer::includeResource("header"); ?>
	<div class="uiMainContent">
		<div id="messageCenter">
			<div class="toolbar">
				<div id="actionControls"></div>
			</div>
			<div id="folders"></div>
			<div id="threads"></div>
			<div id="threadContent"></div>
		</div>
	</div>
</body>
</html>
