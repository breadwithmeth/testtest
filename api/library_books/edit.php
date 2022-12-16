<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/staff.php';
include_once '../../models/library_books.php';

$database = new Database();
$db = $database->connect();
$staff = new Staff($db);
$book = new library_books($db);
$data = json_decode(file_get_contents("php://input"), true);
if ($staff->isLoggedIn) {
    echo json_encode($book->edit($data));
}else{
    header("HTTP/1.1 401 unauthorized");
}