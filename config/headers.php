<?php
    //Раскоментировать
    // header('Access-Control-Allow-Origin: https://smart.doro.kz');
    
    //Удалить
    header('Access-Control-Allow-Origin: *');

    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: text/plain');
    header('Content-Type: text/html');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    
    // header("strict-transport-security: max-age=600");
    
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With, AUTH, auth');
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, AUTH, auth");
       exit();
    }
    