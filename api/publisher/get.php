<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/publisher.php'; 
include_once '../../models/staff.php'; // обязательное поле

$database = new Database();
$db = $database->connect();
$publisher = new Publisher($db);
$staff = new Staff($db); // обязательное поле
$data = json_decode(file_get_contents("php://input"), true);
if ($staff->isLoggedIn) { // обязательно
    echo json_encode($publisher->get($data));
}else{
    header("HTTP/1.1 401 unauthorized");
}