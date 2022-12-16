<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';


$database = new Database();
$db = $database->connect();

$result = $db->query("SELECT id FROM bibliographic_descriptions ");
$res = [];
while ($row = $result->fetch_array()) {
    array_push($res, $row['id']);
}
echo json_encode($res);