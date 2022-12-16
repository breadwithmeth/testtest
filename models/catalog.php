<?php

class Catalog{
    private $db;
    function __construct($db)
    {
        $this->db = $db;
    }
    function add($data){
        
        
        
    }
    function get($data){
        $authors = [];
        if (isset($data['keyword'])) {
            $stmt = $this->db->prepare("SELECT `id`, `code`, `name` FROM `catalogs`  WHERE `name` LIKE ? or `code` LIKE ?");
            $keyword = $data['keyword'].'%';
            $stmt->bind_param("ss", $keyword, $keyword);
            $stmt->execute();
            
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                array_push($authors, $row);

            }
            return $authors;
        }
        else {
            $stmt = $this->db->prepare("SELECT id, `code`, `name` FROM `catalogs` ");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                array_push($authors, $row);
    
            }
            return $authors;
        }
    
    }
}