<?php
include_once '../../config/Database.php';
include_once '../../config/headers.php';
include_once '../../models/places_of_publication.php';

$database = new Database();
$db = $database->connect();
$class = new places_of_publication($db);
$data = json_decode(file_get_contents("php://input"), true);

$result = $class->add($data);
echo()