<?php
require 'user.php';
session_start();

$username = '';
$password = '';
$email = '';

if (isset($_POST['username'])) {
    $username = $_POST["username"];
}
if (isset($_POST['password'])) {
    $password = $_POST["password"];
}
if (isset($_POST['email'])) {
    $email = $_POST["email"];
}

$userObj = new User();

//Registering the user
if (!empty($username) && !empty($password) && !empty($email)) {
    $hashed_password = password_hash($password, PASSWORD_ARGON2I);
    $json_registeration = $userObj->register($username, $email, $hashed_password);
    echo json_encode($json_registeration);
}
//Login the user
if (!empty($username) && !empty($password) && empty($email)) {
    $hashed_password = password_hash($password, PASSWORD_ARGON2I);
    $json_login = $userObj->login($username, $hashed_password);
    echo json_encode($json_login);
}
