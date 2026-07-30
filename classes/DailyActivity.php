<?php

require_once "Database.php";
class DailyActivity
{
    private $conn;

    public function __construct()
    {

        $database = new Database();

        $this->conn = $database->connect();

    }

    public function addActivity($userId, $type)
    {

        $date = date("Y-m-d");

        $query = "

        INSERT INTO daily_activities

        (user_id, activity_type, activity_date, status)

        VALUES (?, ?, ?, 1)

        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([

            $userId,

            $type,

            $date

        ]);

    }


    public function getTodayActivity($userId)
    {
        $date = date("Y-m-d");

        $query = "

        SELECT *

        FROM daily_activities

        WHERE user_id = ?

        AND activity_date = ?

        ORDER BY id DESC

        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([

            $userId,

            $date

        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


}