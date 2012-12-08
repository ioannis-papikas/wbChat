<?php
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

<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Chatroom</title>
</head>

<body>
</body>
</html>
