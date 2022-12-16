<?php

class customer_education_list
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function add($data)
    {
        $stmt = $this->db->prepare("SELECT * FROM `customer_education_list` WHERE `title`=?");
        $stmt->bind_param('s', $data['title']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row != null) {
            header("HTTP/1.1 409 libraries with name already exists");
            return 'Такой жанр с названием именем уже есть!';
        } else {
            $stmt = $this->db->prepare("INSERT INTO `customer_education_list` (`title`) VALUES (?)");
            $stmt->bind_param('s', $data['title']);
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
        $stmt = $this->db->prepare("SELECT * FROM `customer_education_list`");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }
        return $arr;
    }

    function edit($data)
    {
        $stmt = $this->db->prepare("UPDATE `customer_education_list` SET `title` = ? WHERE `id` = ?");
        $stmt->bind_param('ssi', $data['title'], $data['id']);
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
        $stmt = $this->db->prepare("DELETE FROM `customer_education_list` WHERE `id` = ?");
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