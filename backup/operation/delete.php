<?php

// authentication
include '../auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object files
include_once '../config/db.php';
include_once '../object/operation.php';

$database = new Db();
$db = $database->getConnection();

// initialize object
$operation = new Operation($db);

// set ID property of operation to be deleted
$operation->id = filter_input(INPUT_GET, 'id');

// delete the department
if ($operation->delete()) {
    echo '{';
    echo '"message": "Operation '.$operation->id.' was deleted."';
    echo '}';
}

// if unable to delete the operation
else {
    echo '{';
    echo '"message": "Unable to delete operation '.$operation->id.'."';
    echo '}';
}
?>
