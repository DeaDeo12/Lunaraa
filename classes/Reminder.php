<?php

require_once "Database.php";

class Reminder
{
    private $conn;

    public function __construct()
    {

        $database = new Database();
        $this->conn = $database->connect();

    }

    public function save($userId, $type, $time)
    {

        $query = "
        INSERT INTO reminders
        (user_id, type, time)
        VALUES (?, ?, ?)
        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $userId,
            $type,
            $time
        ]);

    }

    public function getReminder($userId)
    {

        $query = "
        SELECT *
        FROM reminders
        WHERE user_id = ?
        ORDER BY id DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getReminderMessage()
    {
        return [

            "💧 Jangan lupa minum air minimal 2 liter hari ini.",

            "💊 Saatnya minum tablet tambah darah.",

            "🩸 Jangan lupa mengganti pembalut setiap 4 jam."

        ];

    }


}