<?php

// authentication
include '../auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/db.php';
include_once '../object/operation.php';

// instantiate database and operation object
$database = new Db();
$db = $database->getConnection();

// initialize object
$operation = new Operation($db);

// set id property of operation to be searched
$operation->id = filter_input(INPUT_GET, 'id');

// query operation
$stmt = $operation->get();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // operation array
    $operation_arr = array();
    $operation_arr["records"] = array();

    // retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        extract($row);
        $operation_item = array(
            "id" => intval($row['id']),
            "account" => $row['account'],
            "date" => $row['date'],
            "amount" => intval($row['amount']),
            "description" => $row['description'],
            "tags" => $row['tags']
        );
        array_push($operation_arr["records"], $operation_item);
    }
    echo json_encode($operation_item);
} else {
    echo json_encode(
            array("message" => "No operation found.")
    );
}

?>
