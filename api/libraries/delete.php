<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/libraries.php';

$database = new Database();
$db = $database->connect();
$libraries = new libraries($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($libraries->delete($data));