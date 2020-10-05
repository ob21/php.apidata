
<?php

// authentication
include 'conf/auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database file
include_once 'conf/db.php';

// get id of item from the url
$type=strval($_GET["type"]);
$value=strval($_GET["value"]);
if(empty($type)) {
    $data = array();
    $data["error"] = "type is empty";
    exit(json_encode($data));
}
if(empty($value)) {
    $data = array();
    $data["error"] = "value is empty";
    $data(json_encode($data));
}

// instantiate database and open connection
$database = new Db();
$connection = $database->getConnection();

// make query
$query = "INSERT INTO data (type, value) VALUES ('".$type."','".$value."')";
$statement = $connection->prepare($query);
$statement->execute();

// result
$num = $statement->rowCount();

$data = array();
$data["result"] = $num." item created";
echo json_encode($data);

?>
