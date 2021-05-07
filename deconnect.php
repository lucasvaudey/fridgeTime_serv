<?php
if(isset($_POST["disconnect"])){
    session_id($_POST["disconnect"]);
    session_start();
    $result = session_destroy();
    $json = array();
    if($result){
        $json["success"] = 1;
    }else{
        $json["success"] = 0;
    }
    echo json_encode($json);
}
?>