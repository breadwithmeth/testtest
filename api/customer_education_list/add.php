<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/customer_education_list.php';

$database = new Database();
$db = $database->connect();
$customer_education_list = new customer_education_list($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($customer_education_list->add($data));