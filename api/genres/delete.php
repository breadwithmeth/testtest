<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/genres.php';

$database = new Database();
$db = $database->connect();
$genres = new genres($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($genres->delete($data));