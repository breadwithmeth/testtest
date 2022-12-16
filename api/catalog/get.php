<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/catalog.php';

$database = new Database();
$db = $database->connect();
$catalog = new Catalog($db);
$data = json_decode(file_get_contents("php://input"), true);
echo json_encode($catalog->get($data), JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_UNESCAPED_UNICODE);