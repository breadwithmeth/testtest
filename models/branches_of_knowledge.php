<?php

class branches_of_knowledge
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function add($data)
    {
        $stmt = $this->db->prepare("SELECT * FROM `branches_of_knowledge` WHERE `name_ru`=? OR `name_kz`=?");
        $stmt->bind_param('ss', $data['name_ru'], $data['name_kz']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row != null) {
            header("HTTP/1.1 409 libraries with name already exists");
            return 'Такой жанр с названием именем уже есть!';
        } else {
            $stmt = $this->db->prepare("INSERT INTO `branches_of_knowledge` (`name_ru`, `name_kz`) VALUES (?,?)");
            $stmt->bind_param('ssss', $data['name_ru'], $data['name_kz']);
            $result = $stmt->execute();
            if ($result) {
                return $result;
            } else {
                header("HTTP/1.1 501 error while inserting");
                return $result;
            }
        }
    }

    function get()
    {
        $arr = [];
        $stmt = $this->db->prepare("SELECT * FROM `branches_of_knowledge`");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }
        return $arr;
    }

    function edit($data)
    {
        $stmt = $this->db->prepare("UPDATE `branches_of_knowledge` SET `name_ru` = ?, `name_kz` = ? WHERE `id` = ?");
        $stmt->bind_param('ssi', $data['name_ru'], $data['name_kz'],$data['id']);
        $result = $stmt->execute();
        if ($result) {
            return $result;
        } else {
            header("HTTP/1.1 500 bad request");
            return $result;
        }
    }

    function delete($data)
    {
        $stmt = $this->db->prepare("DELETE FROM `branches_of_knowledge` WHERE `id` = ?");
        $stmt->bind_param('i', $data['id']);
        $result = $stmt->execute();
        if ($result) {
            return $result;
        } else {
            header("HTTP/1.1 500 bad request");
            return $result;
        }
    }
}