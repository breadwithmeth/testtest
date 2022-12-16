<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/select.php';

$database = new Database();
$db = $database->connect();
$select = new Select($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($select->edit($data));