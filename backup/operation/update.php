<?php

// authentication
include '../auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/db.php';
include_once '../object/operation.php';

$database = new Db();
$db = $database->getConnection();

// initialize object
$operation = new Operation($db);

// get posted data
$data = json_decode(file_get_contents("php://input", true));

// set ID property of operation to be updated
$operation->id = $data->id;
// set operation property values
$operation->account = $data->account;
$operation->date = $data->date;
$operation->amount = $data->amount;
$operation->description = $data->description;
$operation->tags = $data->tags;

// update the operation
if ($operation->update()) {
    echo '{';
    echo '"message": "Operation '.$operation->id.' was updated."';
    echo '}';
}

// if unable to update the operation, tell the user
else {
    echo '{';
    echo '"message": "Unable to update operation '.$operation->id.'."';
    echo '}';
}
