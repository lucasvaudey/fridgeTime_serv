<?php
if (isset($_GET["isAuth"])) {
    if($_GET["isAuth"] != null){
        session_id($_GET["isAuth"]);
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
