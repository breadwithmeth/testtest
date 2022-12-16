<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/branches_of_knowledge.php';

$database = new Database();
$db = $database->connect();
$branches_of_knowledge = new branches_of_knowledge($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($branches_of_knowledge->delete($data));