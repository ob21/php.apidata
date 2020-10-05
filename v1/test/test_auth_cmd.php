<?php

// authentication
include 'stub.php';
include '../conf/auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Send status response
echo json_encode(
	array("message" => "Authentication succeed")
);

?>
