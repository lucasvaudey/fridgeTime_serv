<?php
include 'config.php';

class DBconnect
{

    private $connect;

    public function __construct()
    {
        try {
            $this->connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        } catch (PDOException $e) {
            echo "Impossible de se connecter à la base de données : " . $e;
        }
    }
    public function getDB()
    {
        return $this->connect;
    }
}
