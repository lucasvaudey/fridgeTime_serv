<?php

include 'db-connect.php';

class User
{
    private $db;
    private $db_table = "user";
    public function __construct()
    {
        $this->db = new DBconnect();
    }

    public function isEmailExist($email)
    {
        $query = "select * from " . $this->db_table . " where email = '$email' Limit 1";
        $result = mysqli_query($this->db->getDB(), $query);
        if (mysqli_num_rows($result) > 0) {
            return true;
        }
        return false;
    }

    public function isEmailValid($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isLoginExist($username)
    {
        $query = "select * from " . $this->db_table . " where username = '$username' Limit 1";
        $result = mysqli_query($this->db->getDB(), $query);
        if (mysqli_num_rows($result) > 0) {
            return true;
        }
        return false;
    }

    public function register($username, $email, $password)
    {
        $isExistingEmail = $this->isEmailExist($email);
        $isExistingUsername = $this->isLoginExist($username);
        $emailValid = $this->isEmailValid($email);
        $json = array();

        if (!$emailValid) {
            $json["success"] = 0;
            $json["field"] = "email";
            $json["message"] = "L'email n'est pas valide.";
        } else if ($isExistingEmail) {
            $json["success"] = 0;
            $json["field"] = "email";
            $json["message"] = "L'email existe déjà.";
        } else if ($isExistingUsername) {
            $json["success"] = 0;
            $json["field"] = "username";
            $json["message"] = "Ce nom d'utilisateur existe déjà.";
        } else {
            $query = "insert into " . $this->db_table . " (email, username, password, recipes, fridge, subscribecategories) VALUES ('$email', '$username', '$password', NULL, NULL, NULL)";
            $inserted = mysqli_query($this->db->getDB(), $query);
            if ($inserted == 1) {
                $json["success"] = 1;
                $json["field"] = "none";
                $json["message"] = "Succès sur l'enregistrement";
                $json["sessionID"] = session_id();
                $_SESSION['username'] = $username;
            } else {
                $json["success"] = 0;
                $json["field"] = "none";
                $json["message"] = "Une erreur est apparu";
            }
        }
        return $json;
    }

    public function login($usernameOrEmail, $password)
    {
        $json = array();
        $isExistingEmail = $this->isEmailExist($usernameOrEmail);
        $isExistingUsername = $this->isLoginExist($usernameOrEmail);
        if (!$isExistingEmail && !$isExistingUsername) {
            $json["success"] = 0;
            $json["field"] = "usernameOrEmail";
            $json["message"] = "Cette e-mail ou utilisateur n'existe pas";
        } else if ($isExistingEmail) {
            $password_hashed = mysqli_fetch_array(mysqli_query($this->db->getDB(), "SELECT PASSWORD from " . $this->db_table . " where email = '$usernameOrEmail'"));  
            $password_check = password_verify($password, $password_hashed["PASSWORD"]);
            if ($password_check) {
                $json["success"] = 1;
                $json["field"] = "none";
                $json["message"] = "Vous pouvez vous connectez";
                $query = "SELECT USERNAME from " . $this->db_table . " where email = '$usernameOrEmail'";
                $result = mysqli_query($this->db->getDB(), $query);
                $usernameFetch = mysqli_fetch_array($result);
                $_SESSION["username"] = $usernameFetch["USERNAME"];
                $json["sessionID"] = session_id();
            } else {
                $json["success"] = 0;
                $json["field"] = "password";
                $json["message"] = "Le mot de passe est incorrect";
            }
        } else if ($isExistingUsername) {
            $password_hashed = mysqli_fetch_array(mysqli_query($this->db->getDB(), "SELECT PASSWORD from " . $this->db_table . " where username = '$usernameOrEmail'"));  
            $password_check = password_verify($password, $password_hashed["PASSWORD"]);
            if ($password_check) {
                $json["success"] = 1;
                $json["field"] = "none";
                $json["message"] = "Vous pouvez vous connectez";
                $json["sessionID"] = session_id();
                $_SESSION['username'] = $usernameOrEmail;
            } else {
                $json["success"] = 0;
                $json["field"] = "password";
                $json["message"] = "Le mot de passe est incorrect";
            }
        }
        return $json;
    }
}
