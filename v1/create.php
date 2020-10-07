
<?php

// authentication
include 'conf/auth.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database file
include_once 'conf/db.php';

print_r("POST\n");

echo "<table>";
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
echo "</table>";

// get id of item from the url
$type=strval(htmlspecialchars($_GET["type"]));
if(empty($type)) {
    $type=strval(htmlspecialchars($POST["type"]));
    if(empty($type)) {
       $data = array();
       $data["error"] = "type is empty";
       exit(json_encode($data));
    }
}
$value=strval(htmlspecialchars($_GET["value"]));
if(empty($value)) {
    $value=strval(htmlspecialchars($_POST["value"]));
    if(empty($value)) {
       $data = array();
       $data["error"] = "value is empty";
       exit(json_encode($data));
    }
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
