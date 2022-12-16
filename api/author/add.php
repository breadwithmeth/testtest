<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/author.php';

$database = new Database();
$db = $database->connect();
$author = new Author($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($author->add($data));