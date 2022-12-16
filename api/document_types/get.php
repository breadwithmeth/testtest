<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/document_types.php';

$database = new Database();
$db = $database->connect();
$class = new document_types($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($class->get());