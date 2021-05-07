<?php
if (isset($_POST["isAuth"])) {
    if($_POST["isAuth"] != null){
        session_id($_POST["isAuth"]);
    }
    session_start();
    switch (empty($_SESSION)) {
        case true:
            $json['id'] = "noId";
            break;
        case false:
            $json['id'] = "wat ?";
            $json['username'] = $_SESSION['username'];
            break;
    }
    echo json_encode($json);
}
