<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/sources_of_income.php';

$database = new Database();
$db = $database->connect();
$class = new sources_of_income($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($class->get());