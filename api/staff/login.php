<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/staff.php';


$database = new Database();
$db = $database->connect();
$staff = new Staff($db);

$data = json_decode(file_get_contents("php://input"), true);
    
    
    echo json_encode($staff->login($data['login'], $data['password']));