<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/staff.php';
include_once '../../models/language.php';

$database = new Database();
$db = $database->connect();
$staff = new Staff($db);
$language = new Language($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($language->get($data));
// if ($staff->isLoggedIn) {
// }else{
//     header("HTTP/1.1 401 unauthorized");
// }
