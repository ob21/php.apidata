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

// set account property of operation to be searched
$operation->account = filter_input(INPUT_GET, 'account');
$operation->date = filter_input(INPUT_GET, 'date');
$operation->date_before = filter_input(INPUT_GET, 'date_before');
$operation->date_after = filter_input(INPUT_GET, 'date_after');
$operation->amount = filter_input(INPUT_GET, 'amount');
$operation->amount_less_than = filter_input(INPUT_GET, 'amount_less_than');
$operation->amount_more_than = filter_input(INPUT_GET, 'amount_more_than');
$operation->description = filter_input(INPUT_GET, 'description');
$operation->description_contains = filter_input(INPUT_GET, 'description_contains');
$operation->tags = filter_input(INPUT_GET, 'tags');
$operation->tags_contains = filter_input(INPUT_GET, 'tags_contains');
$operation->limit = filter_input(INPUT_GET, 'limit');
$operation->offset = filter_input(INPUT_GET, 'offset');

// query operation
$stmt = $operation->search();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // operation array
    $operation_arr = array();
    $operation_arr["records"] = array();
    $operation_arr["logs"] = array();
    array_push($operation_arr["logs"], $operation);

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
    echo json_encode($operation_arr);
} else {
    echo json_encode(
            array("message" => "No operations found.", 
            "log" => $operation->log, 
            "statement query string" => $stmt->queryString, 
            "statement error" => $stmt->error)
    );
}

?>
