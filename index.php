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

?>

<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Chatroom</title>
</head>

<body>
</body>
</html>
