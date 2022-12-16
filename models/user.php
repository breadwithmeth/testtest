<?php

class User{
    private $db;
    function __construct($db)
    {
        $this->db = $db;
    }
    function getStat($data){
        try {
            $arr = [];
    $stmt = $this->db->prepare("SELECT `id`,`date_reg` FROM `users` WHERE `date_reg`>=? AND `date_reg`<=? AND `viz`=0");
    $stmt->bind_param('ss',$data['start'],$data['end']);
            $stmt->execute();
    $result = $stmt->get_result();
    
    $january = 0; $february = 0; $march = 0; $april = 0; $may = 0; $june = 0; $july = 0; $august = 0; $september = 0; $october = 0; $november = 0; $december = 0;
    while ($row = $result->fetch_assoc()){
        if (strpos($row['date_reg'], '-01-')) $january += 1;
        elseif (strpos($row['date_reg'], '-02-')) $february += 1;
        elseif (strpos($row['date_reg'], '-03-')) $march += 1;
        elseif (strpos($row['date_reg'], '-04-')) $april += 1;
        elseif (strpos($row['date_reg'], '-05-')) $may += 1;
        elseif (strpos($row['date_reg'], '-06-')) $june += 1;
        elseif (strpos($row['date_reg'], '-07-')) $july += 1;
        elseif (strpos($row['date_reg'], '-08-')) $august += 1;
        elseif (strpos($row['date_reg'], '-09-')) $september += 1;
        elseif (strpos($row['date_reg'], '-10-')) $october += 1;
        elseif (strpos($row['date_reg'], '-11-')) $november += 1;
        else $december += 1;
    }
    array_push($arr, $january, $february, $march, $april, $may, $june,$july, $august, $september,$october,$november,$december);
    return $arr;
        } catch (\Throwable $th) {
            echo $th;
            
        }
        
    }
}