<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/classifiers.php';

$database = new Database();
$db = $database->connect();
$classifiers = new classifiers($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($classifiers->add($data));