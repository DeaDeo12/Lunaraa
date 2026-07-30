<?php

require_once "Database.php";

class User
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();

    }

    public function register($nama, $email, $password)
    {

        /*CEK EMAIL*/
        $cek = $this->conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $cek->execute([$email]);

        if($cek->fetch()){

            return "EMAIL_SUDAH_ADA";

        }

        /*HASH*/
        $password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $query = "
        INSERT INTO users
        (nama,email,password)
        VALUES(?,?,?)
        ";

        $stmt = $this->conn->prepare($query);

        if($stmt->execute([

            $nama,
            $email,
            $password

        ])){

            return "BERHASIL";
        }

        return "GAGAL";
    }

    public function login($email, $password)
    {
        $query = "
        SELECT *
        FROM users
        WHERE email = ?
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(
            $user &&
            password_verify(
                $password,
                $user['password']
            )
        ){

            return $user;
        }

        return false;

    }

    public function getProfile($userId)
    {

        $query = "
        SELECT *
        FROM users
        WHERE id = ?
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            $userId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function updateProfile($userId, $nama, $email)
    {

        $query = "
        UPDATE users
        SET nama = ?, email = ?
        WHERE id = ?
        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $nama,
            $email,
            $userId
        ]);

    }

}
