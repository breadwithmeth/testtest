<?php

class Publisher{
    private $db;
    function __construct($db)
    {
        $this->db = $db;
    }
    function add($data){
        $stmt = $this->db->prepare("INSERT INTO `publishers`(`code`, `name`) VALUES (?,?)");
        $stmt->bind_param("ss", $data['code'], $data['name']);
        $result = $stmt->execute();
        return $result;
    }
    function get($data){
        try {
            $authors = [];
            if (isset($data['keyword'])) {
                $stmt = $this->db->prepare("SELECT * FROM `publishers`  WHERE `code` LIKE ? or `name` LIKE ?");
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
                $stmt = $this->db->prepare("SELECT * FROM `publishers` ");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($authors, $row);
        
                }
                return $authors;
            }
            //code...
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}