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
            $query = "insert into " . $this->db_table . " (email, username, password, recipes, frigde, subscribecategories) VALUES ('$email', '$username', '$password', NULL, NULL, NULL)";
            $inserted = mysqli_query($this->db->getDB(), $query);
            if ($inserted == 1) {
                $json["success"] = 1;
                $json["field"] = "none";
                $json["message"] = "Succès sur l'enregistrement";
                $_SESSION['isLogged'] = true;
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
        $isExistingUsername = $this->isEmailExist($usernameOrEmail);
        if (!$isExistingEmail && !$isExistingUsername) {
            $json["success"] = 0;
            $json["field"] = "usernameOrEmail";
            $json["message"] = "Cette e-mail ou utilisateur n'existe pas";
        } else if ($isExistingEmail) {
            $query = "select * from " . $this->db_table . " where email = '$usernameOrEmail' AND password = '$password'";
            $result = mysqli_query($this->db->getDB(), $query);
            if (mysqli_num_rows($result) > 0) {
                $json["success"] = 1;
                $json["field"] = "none";
                $json["message"] = "Vous pouvez vous connectez";
                $query = "SELECT username from " . $this->db_table . " where email = '$usernameOrEmail'";
                $result = mysqli_query($this->db->getDB(), $query);
                $_SESSION['isLogged'] = true;
                $_SESSION['username'] = mysqli_fetch_field($result);
            } else {
                $json["success"] = 0;
                $json["field"] = "password";
                $json["message"] = "Le mot de passe est incorrect";
            }
        } else if ($isExistingUsername) {
            $query = "select * from " . $this->db_table . " where username = '$usernameOrEmail' AND password = '$password'";
            $result = mysqli_query($this->db->getDB(), $query);
            if (mysqli_num_rows($result) > 0) {
                $json["success"] = 1;
                $json["field"] = "none";
                $json["message"] = "Vous pouvez vous connectez";
                $_SESSION['isLogged'] = true;
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
