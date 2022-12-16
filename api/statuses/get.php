<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/statuses.php';

$database = new Database();
$db = $database->connect();
$class = new statuses($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($class->get());