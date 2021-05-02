<?php
session_start();
if (isset($_GET["isAuth"])) {
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
