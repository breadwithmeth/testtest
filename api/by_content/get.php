<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/by_content.php';

$database = new Database();
$db = $database->connect();
$class = new by_content($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($class->get());