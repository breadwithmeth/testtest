<?php

class Staff
{
    private $db;

    public $id;
    public $role;
    public $library_id;
    public $isLoggedIn = false;
    public $token;

    function __construct($db)
    {
        $this->db = $db;
        session_start();
        if (isset($_SERVER['HTTP_AUTH'])) {
            $result = $this->checkKeyAuth($_SERVER['HTTP_AUTH']);
            if ($result != false) {
                $this->isLoggedIn = true;
                $this->id = $result['id'];
                $this->library_id = $result['library_id'];
                //echo $_SERVER['HTTP_AUTH'];
            } else {
                $this->isLoggedIn = false;
                // echo 'Ты дурак?';
                //exit();
                //return false;
            }
        }
    }

    public function checkKeyAuth($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM `employees` WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result == NULL) {
            return false;
        } else {
            //var_dump($result);
            return $result;
        }
    }


    function login($login, $password)
    {
        if (empty($password)) {
            echo false;
            header("HTTP/1.1 400 login is empty");

        } elseif (empty($login)) {
            echo false;
            header("HTTP/1.1 400 password is empty");

            // }
            // elseif (empty($area_id)) {
            //     echo false;
            //     header("HTTP/1.1 400 area_id is empty");
        } else {
            // $query = "SELECT `w`.`login`, `w`.`password`, `w`.`first_name`, `w`.`middle_name`, `w`.`last_name`, `w`.`idDeleted`, `w`.`photo`, `w`.`position_id`, `p`.`title`, `p`.`access_level`  FROM `workers` `w` LEFT JOIN `possitions` `p` ON `w`.`position_id` = `p`.`position_id` WHERE `w`.`login` = '$login'";
            // $result = $this->db->query($query);
            // $result = $result->fetch_assoc();
            $stmt = $this->db->prepare("SELECT `e`.`id`, `e`.`first_name`, `e`.`last_name`, `e`.`middle_name`, `e`.`library_id`, `e`.`is_deleted`, `roles`.title FROM employees `e` 
                LEFT JOIN roles ON roles.id = e.role_id
                WHERE `e`.`phone_number`=? and `e`.`password`=? ");
            $stmt->bind_param("ss", $login, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row == NULL) {
                header("HTTP/1.1 403 User not found");
                return json_encode(false);
            } else {
                if ($row['is_deleted'] == 0) {
                    $uuid = crypt(time(), "3c6b8f7676");
                    $this->isLoggedIn = true;
                    $stmt = $this->db->prepare("UPDATE `employees` SET `token` = '{$uuid}' WHERE `id` = '{$row['id']}'");
                    $result = $stmt->execute();
                    if ($result) {
                        $row['token'] = $uuid;
                        return $row;
                    }
                } else {
                    header("HTTP/1.1 403 User is delited");
                    return json_encode(true);
                }
                // }else{
                //     header("HTTP/1.1 403 Access denied");
                //     return json_encode(false);

            }
        }
    }
    function add($data, $lib_id){
        try {
            if (isset($lib_id)){
                if (isset($data)) {
                    $stmt = $this->db->prepare("INSERT INTO `employees` (`first_name`, `last_name`, `middle_name`, `phone_number`, `date_of_birth`, `library_experience`, `general_experience`, `passport_number`, `nation_id`, `iin`, `address`, `password`, `position_id`, `library_id`, `gender_id`, `education_id`, `role_id`, `family_status`) 
VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('sssssiiiiissiiiiii', $data['first_name'], $data['last_name'], $data['middle_name'], $data['phone_number'], $data['date_of_birth'], $data['library_experience'], $data['general_experience'], $data['passport_number'], $data['nation_id'], $data['iin'], $data['address'], $data['password'], $data['position_id'], $lib_id, $data['gender_id'], $data['education_id'], $data['role_id'], $data['family_status']);
                    $res = $stmt->execute();
                    if ($res) {
                        return $res;
                    }else{
                        header("HTTP/1.1 500 table not updating");
                        return $res;
                    }
                }else{
                    header("HTTP/1.1 400 data is empty");
                    return false;
                }
            }else{
                header("HTTP/1.1 400 library id is empty");
                return false;
            }
        }catch (\Throwable $th){
            return $th;
        }
    }
    function edit($data, $lib_id){
        try {
            if (isset($lib_id)){
                if (isset($data)){
                    $stmt = $this->db->prepare("UPDATE `employees` SET `first_name` = ?, `last_name` = ?, `middle_name` = ?, `phone_number` = ?, `date_of_birth` = ?, `library_experience` = ?, `general_experience` = ?, `passport_number` = ?, `nation_id` = ?, `iin` = ?, `address` = ?, `password` = ?, `position_id` = ?, `gender_id` = ?, `education_id` = ?, `role_id` = ?, `family_status` = ? WHERE `id` = ? AND `library_id`=?");
                    $stmt->bind_param('sssssiiiiissiiiiiii',$data['first_name'], $data['last_name'], $data['middle_name'], $data['phone_number'], $data['date_of_birth'], $data['library_experience'], $data['general_experience'], $data['passport_number'], $data['nation_id'], $data['iin'], $data['address'], $data['password'], $data['position_id'], $data['gender_id'], $data['education_id'], $data['role_id'], $data['family_status'], $data['id'], $lib_id);
                    $res = $stmt->execute();
                    if ($res) {
                        return $res;
                    }else{
                        header("HTTP/1.1 500 table not updating");
                        return $res;
                    }
                }else{
                    header("HTTP/1.1 400 data is empty");
                    return false;
                }
            }else{
                header("HTTP/1.1 400 library id is empty");
                return false;
            }
        }catch (\Throwable $th){
            return $th;
        }
    }
    function delete($data,$lib_id){
        try {
            if (isset($lib_id)){
                if (isset($data)){
                    $stmt = $this->db->prepare("DELETE FROM `employees` WHERE `id` = ? AND `library_id`= ?");
                    $stmt->bind_param('ii', $data['id'],$lib_id);
                    $res = $stmt->execute();
                    if ($res) {
                        return $res;
                    }else{
                        header("HTTP/1.1 500 table not updating");
                        return $res;
                    }
                }else{
                    header("HTTP/1.1 400 data is empty");
                    return false;
                }
            }else{
                header("HTTP/1.1 400 library id is empty");
                return false;
            }
        }catch (\Throwable $th){
            return $th;
        }
    }
}