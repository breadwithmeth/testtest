<?php

class Language{
    private $db;
    function __construct($db)
    {
        $this->db = $db;
    }
    function add($data){
        
        
        
    }
    function get($data){
        $resultArr = [];
        $stmt = $this->db->prepare("SELECT * FROM `languages`");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($resultArr, $row);
        }
        return $resultArr;
    }
}