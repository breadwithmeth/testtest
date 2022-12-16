<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/bibliographic_descriptions.php';

$database = new Database();
$db = $database->connect();
$book = new bibliographic_description($db);

echo json_encode($book->add());