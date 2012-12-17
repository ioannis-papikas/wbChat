<?php
require_once 'system/core/database/dbmanager.php';
try {
$db = new dbManager();
} catch (UnexpectedValueException $ex) {
    echo $ex->getMessage();
}

$queryCreator = new SqlQueryCreator();
$queryCreator->selectFromTables(array(
    'tableA' => array(
        'colA1', 'colA2'
    )
));
$queryCreator->from('tableA', 'a');
echo $queryCreator->getStatement();

// Require System Configuration
require_once("_config.php");

// Require Libraries
?>
<!DOCTYPE>
<html>
<?php importer::includeResources("head"); ?>
<body>
<?php importer::includeResources("header"); ?>
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
