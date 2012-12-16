<?php
// Require System Configuration
require_once("_config.php");
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
