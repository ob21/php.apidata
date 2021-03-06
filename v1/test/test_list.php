
<?php

// authentication
include '../conf/auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database file
include_once '../conf/db.php';

// instantiate database and open connection
$database = new Db();
$connection = $database->getConnection();

// make query
$query = "SELECT * FROM data ORDER BY id";
$statement = $connection->prepare($query);
$statement->execute();

// result
$num = $statement->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // result array
    $data = array();
    $data["status"] = true;
    $data["result"] = array();

    // retrieve table contents
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        extract($row);
        $item = array(
            "id" => intval($row['id']),
            "type" => $row['type'],
            "value" => $row['value']
	);
        array_push($data["result"], $item);
    }
    echo json_encode($data);
} else {
    $data = array();
    $data["status"] = false;
    $data["result"] = "No data found";
    echo json_encode($data);
}
$statement->close();

?>
