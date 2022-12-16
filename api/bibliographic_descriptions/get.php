<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/staff.php';
include_once '../../models/bibliographic_descriptions.php';
require  '../../vendor/autoload.php';
use Respect\Validation\Validator as v;
use Respect\Validation\Factory;
$database = new Database();
$db = $database->connect();
$staff = new Staff($db);
$book = new bibliographic_description($db);
$data = json_decode(file_get_contents("php://input"), true);
v::json()->validate($data); 
if ($staff->isLoggedIn) {
    echo json_encode($book->get($data, $staff->library_id));
}else{
    header("HTTP/1.1 401 unauthorized");
}
