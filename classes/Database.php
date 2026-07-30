<?php

class Database
{
    private $connection;

    public function connect()
    {
        try {

            $databasePath = __DIR__ . "/../database/lunara.db";

            $this->connection = new PDO("sqlite:" . $databasePath);

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->connection;

        } catch (PDOException $e) {

            die("Koneksi gagal : " . $e->getMessage());

        }
    }
}