<?php

class libraries
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function add($data)
    {
        $stmt = $this->db->prepare("SELECT * FROM `libraries` WHERE `name`=? OR `name_kz`=?");
        $stmt->bind_param('ss', $data['name'], $data['name_kz']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row != null) {
            header("HTTP/1.1 409 libraries with name already exists");
            return 'Такая библиотека с такием именем уже есть!';
        } else {
            $stmt = $this->db->prepare("INSERT INTO `libraries` (`name`, `name_kz`, `address`, `sigla`, `phone_number`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss',$data['name'],$data['name_kz'],$data['address'],$data['sigla'],$data['phone_number']);
            $result = $stmt->execute();
            if ($result) {
                return $result;
            } else {
                header("HTTP/1.1 501 error while inserting");
                return $result;
            }
        }
    }

    function get($data)
    {
        $arr = [];
        $stmt = $this->db->prepare("SELECT * FROM `libraries`");
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            array_push($arr,$row);
        }
        return $arr;
    }

    function edit($data)
    {
        $stmt = $this->db->prepare("UPDATE `libraries` SET `name` = ?, `name_kz` = ?, `address` = ?, `sigla` = ?, `phone_number` = ? WHERE `id` = ?");
        $stmt->bind_param('sssssi',$data['name'],$data['name_kz'],$data['address'],$data['sigla'],$data['phone_number'],$data['id']);
        $result = $stmt->execute();
        if ($result){
            return $result;
        }else{
            header("HTTP/1.1 500 bad request");
            return $result;
        }
    }

    function delete($data)
    {
        $stmt = $this->db->prepare("DELETE FROM `libraries` WHERE `id` = ?");
        $stmt->bind_param('i',$data['id']);
        $result = $stmt->execute();
        if ($result){
            return $result;
        }else{
            header("HTTP/1.1 500 bad request");
            return $result;
        }
    }

}