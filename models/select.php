<?php

class Select{
    private $db;
    function __construct($db)
    {
        $this->db = $db;
    }
    function add($data){
        $stmt = $this->db->prepare("INSERT INTO `selects`(`type`, `name_kz`, `name_ru`) VALUES (?,?,?)");
        $stmt->bind_param("sss", $data['type'], $data["name_kz"], $data["name_ru"]);
        $result = $stmt->execute();
        return $result;
        
    }

    function edit($data){
        if (isset($data["id"])) {
            $stmt = $this->db->prepare("UPDATE `selects` SET `name_kz`=?,`name_ru`=? WHERE `id` = ?");
            $stmt->bind_param("sss", $data['name_kz'], $data['name_ru'], $data["id"]);
            $result = $stmt->execute();
            return $result;
        }else{
            header("HTTP/1.1 400 need to specify id");
            return false;
        }
    }


    function get($data){
        try {
            $authors = [];
            if (isset($data['keyword'])) {
                $stmt = $this->db->prepare("SELECT author_id ,CONCAT(last_name, ' ', first_name, ' ', middle_name) `name`, CONCAT(last_name_lat, ' ', first_name_lat, ' ', middle_name_lat) `name_lat` FROM `authors`  WHERE `last_name` LIKE ? or `last_name_lat` LIKE ?");
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
                $stmt = $this->db->prepare("SELECT author_id ,CONCAT(last_name, ' ', first_name, ' ', middle_name) `name`, CONCAT(last_name_lat, ' ', first_name_lat, ' ', middle_name_lat) `name_lat` FROM `authors` ");
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