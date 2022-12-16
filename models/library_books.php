<?php

class library_books
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function add($data,$library_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `library_books` WHERE `library_id`=? AND `inventory_number`=?");
            $stmt->bind_param("ii", $library_id, $data['inventory_number']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row != null) {
                header("HTTP/1.1 409 invent_num with id_sigl already exists");
                return 'Такой инвент. номер с такой сиглой уже есть!';
            } else {
                $stmt = $this->db->prepare("INSERT INTO `library_books` (`library_id`, `book_id`, `inventory_number`, `barcode`,`status`) VALUES (?,?,?,?,?)");
                $stmt->bind_param("iiiii", $library_id, $data['book_id'], $data['inventory_number'], $data['barcode'], $data['status']);
                $result = $stmt->execute();
                if ($result) {
                    return $result;
                } else {
                    header("HTTP/1.1 501 error while inserting");
                    return $result;
                }

            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    function get($data,$library_id)
    {
        try {
            if (isset($data['book_id']) && isset($data['library_id'])) {
                $stmt = $this->db->prepare("SELECT * FROM `library_books` WHERE `book_id` = ? AND `library_id` = ?");
                $stmt->bind_param("ii", $data['book_id'], $library_id);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                if (isset($data['book_id'])) {
                    $stmt = $this->db->prepare("SELECT * FROM `library_books` WHERE `book_id` = ?");
                    $stmt->bind_param("i", $data['book_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } elseif (isset($data['library_id'])) {
                    $stmt = $this->db->prepare("SELECT * FROM `library_books` WHERE `library_id` = ?");
                    $stmt->bind_param("i", $library_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    header("HTTP/1.1 400 bad request");
                    exit();
                }

            }
            $resultArr = [];
            while ($row = $result->fetch_assoc()) {
                array_push($resultArr, $row);
            }
            return $resultArr;
        } catch (\Throwable $th) {
            return $th;
        }
    }
    function edit($data){
        try {
            $stmt = $this->db->prepare("UPDATE `library_books` SET `status`=? WHERE `id`=?");
            $stmt->bind_param("i",$data['status'],$data['id']);
        }catch (\Throwable $th){
            return $th;
        }
    }
    function delete($data){
        try {
            $stmt = $this->db->prepar("DELETE FROM `library_books` WHERE `id`=?");
            $stmt->bind_param('i',$data['id']);
            $res = $stmt->execute();
            if ($res){
                return $res;
            }else{
                header("HTTP/1.1 501 update table failed");
                return $res;
            }
        }catch (\Throwable $th){
            return $th;
        }
    }
}