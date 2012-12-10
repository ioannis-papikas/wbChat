<?php
<<<<<<< HEAD
// Require System Configuration
require_once("_config.php");

// Require Libraries
?>
=======
require_once 'system/core/database/dbmanager.php';

$db = new dbManager();
if ( !is_resource( $db->getConnection() ) ) {
    echo 'error';
} else {
    echo 'ok';
}

$sql = new SqlQueryCreator();
$columns = array(
    'A' => array('name')
);
$stmt = $sql->select($columns);
if ($stmt === 'SELECT `A`' . '.`name`') {
    echo 'sql ok';
} else {
    echo 'sql failed';
}

?>

>>>>>>> ad764805a59eae98128c5e3a3a2bc72510818ab9
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
