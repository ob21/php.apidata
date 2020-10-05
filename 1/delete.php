
<?php

// authentication
include 'conf/auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database file
include_once 'conf/db.php';

// get id of item from the url
$id=strval($_GET["id"]);
if(empty($id)) {
    $data = array();
    $data["status"] = false;
    $data["result"] = "Id is empty";
    exit(json_encode($data));
}

// instantiate database and open connection
$database = new Db();
$connection = $database->getConnection();

// make query
$query = "DELETE FROM data WHERE id=".$id;
$statement = $connection->prepare($query);
$statement->execute();

// result
$num = $statement->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // result array
    $data = array();
    $data["result"] = $num." item deleted id=".$id;
    echo json_encode($data);
} else {
    $data = array();
    $data["error"] = "No data found";
    echo json_encode($data);
}

?>
