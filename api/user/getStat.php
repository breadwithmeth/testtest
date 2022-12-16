<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/user.php';

$database = new Database();
$db = $database->connect();
$user = new User($db);
$data = json_decode(file_get_contents("php://input"), true);

echo json_encode($user->getStat($data));