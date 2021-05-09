<?php
include '../db-connect.php';
    class fridge{
        private $db;
        private $db_table = 'user';
        public function __construct()
        {
            $this->db = new DBconnect();
        }
        public function getFridgeData(string $sessionID){
            $json = array();
            session_id($sessionID);
            session_start();
            $username = $_SESSION['username'];
            if($username == null){
                $json["noFridge"]=0;
                return $json;
            }
            $response = mysqli_query($this->db->getDB(), "SELECT FRIDGE from " .$this->db_table. " where username = '$username'");
            $fridgeFetch = mysqli_fetch_array($response);
            if($fridgeFetch["FRIDGE"] == null){
                $json["noFridge"] = 0;
                return $json;
            }if ($fridgeFetch["FRIDGE"] == false){
                $json["noFridge"] = 0;
                return $json;
            }else{
                $json = json_decode($fridgeFetch["FRIDGE"],true);
                $json["noFridge"] = 1;
                return $json;
            }
        }
        public function writeFridgeData(string $sessionID, string $data){
            $json = array();
            session_id($sessionID);
            session_start();
            $username = $_SESSION['username'];
            if($username == null){
                $json['success']= 0;
                $json['field'] = 'fridge';
                $json['message'] = 'username not found';
            }
            $inserted = mysqli_query($this->db->getDB(), "UPDATE ".$this->db_table. " SET fridge = '$data' where username = '$username'");
            if($inserted == 1){
                $json['success'] = 1;
                $json['field'] = 'fridge';
                $json['message'] = 'success !';
            }else{
                $json['success'] = 0;
                $json['field'] = 'fridge';
                $json['message'] = 'something went wrong !';
            }
            return $json;
        }
    }
?>