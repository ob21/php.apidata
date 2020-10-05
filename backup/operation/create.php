<?php

// authentication
include '../auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
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

// set operation property values
$operation->account = $data->account;
$operation->date = $data->date;
$operation->amount = $data->amount;
$operation->description = $data->description;
$operation->tags = $data->tags;

// create the operation
$id = $operation->create();
if ($id != -1) {
    echo '{';
    echo '"message": "Operation was created.",';
	 echo '"id": '.$id;
    echo '}';
}

// if unable to create the operation, tell the user
else {
    echo '{';
    echo '"message": "Unable to create operation."';
    echo '}';
}
