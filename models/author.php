<?php

class Author{
    private $db;
    function __construct($db)
    {
        $this->db = $db;
    }
    function add($data){
        if (isset($data['last_name']) && isset($data['first_name'])) {
            $stmt = $this->db->prepare("INSERT INTO `authors`(`first_name`, `last_name`, `middle_name`, `first_name_lat`, `last_name_lat`, `middle_name_lat`) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $data['first_name'], $data['last_name'],$data['middle_name'], $data['first_name_lat'],$data['last_name_lat'], $data['middle_name_lat']);
            $result = $stmt->execute();
            $last_author = $this->db->insert_id;
            $stmt = $this->db->prepare("SELECT author_id ,CONCAT(last_name, ' ', first_name, ' ', middle_name) `name`, CONCAT(last_name_lat, ' ', first_name_lat, ' ', middle_name_lat) `name_lat` FROM `authors`  WHERE `author_id` = ?");
            $stmt->bind_param("s", $last_author);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row;
        }else {
            header("HTTP/1.1 400 first_name and last_name required");

        }
            
        
        
        
    }
    function get($data){
        $authors = [];
        if (isset($data['keyword'])) {
            $stmt = $this->db->prepare("SELECT `id`, `name`, `name_lat` FROM `authors`  WHERE `name` LIKE ? or `name_lat` LIKE ?");
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
            $stmt = $this->db->prepare("SELECT id, `name`, `name_lat` FROM `authors` ");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                array_push($authors, $row);
    
            }
            return $authors;
        }
    
    }
}