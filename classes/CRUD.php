<?php

class CRUD {

    private $db;

    function __construct(){
        $json = file_get_contents("../db.json");
        $db = json_decode($json, true);
        $this->db = $db;
    }
    //select * from users
    function read($tbl_name){
        if(array_key_exists($tbl_name, $this->db) && $tbl_name == 'users'){
            $users = $this->db["users"];
        
            return $users;
        }
        return 0;
    }
    //insert into users values (...$data)
    function create($tbl_name, $data){
        if(array_key_exists($tbl_name, $this->db) && $tbl_name == 'users'){
            $users = $this->db["users"];
        
            $users[] = $data;
            $refresh_users["users"] = $users;
            $json = json_encode($refresh_users);
            
            $fd = fopen("../db.json", 'w') or die("не удалось создать файл");
            fwrite($fd, $json);
            fclose($fd);
        }
    }
    
    // function delete(){
    //     $users = $this->$db["users"];
    //     $refresh_users["users"] = [];
    
    //     $json = json_encode($refresh_users);
    //     $fd = fopen("db.json", 'w') or die("не удалось создать файл");
    //     fwrite($fd, $json);
    //     fclose($fd);
    // }

}