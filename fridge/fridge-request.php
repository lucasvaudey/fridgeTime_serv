<?php
require 'fridge.php';
$fridgeObject = new fridge();

if(isset($_GET['fridge'])){
    $json = array();
    $json = $fridgeObject->getFridgeData($_GET['sessionID']);
    echo json_encode($json);
}
if(isset($_POST['fridgeData'])){
    $json = array();
    $json = $fridgeObject->writeFridgeData($_POST['sessionID'], $_POST['data']);
    echo json_encode($json);
}
?>