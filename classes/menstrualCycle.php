<?php

require_once "Database.php";

class MenstrualCycle
{

    private $conn;

    public function __construct()
    {

        $database = new Database();
        $this->conn = $database->connect();

    }


    public function save($userId, $startDate, $cycleLength, $periodLength)
    {

        $nextPeriod = date(
            "Y-m-d",
            strtotime($startDate . " +{$cycleLength} days")
        );


        $query = "
        INSERT INTO menstrual_cycles
        (user_id,start_date,cycle_length,period_length,next_period)
        VALUES(?,?,?,?,?)
        ";


        $stmt = $this->conn->prepare($query);

        return $stmt->execute([

            $userId,

            $startDate,

            $cycleLength,

            $periodLength,

            $nextPeriod

        ]);

    }


    public function getLatestCycle($userId)
    {

        $query = "
        SELECT *
        FROM menstrual_cycles
        WHERE user_id = ?
        ORDER BY id DESC
        LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function getHistory($userId)
    {

        $query = "
        SELECT *
        FROM menstrual_cycles
        WHERE user_id = ?
        ORDER BY start_date DESC
        ";


        $stmt = $this->conn->prepare($query);


        $stmt->execute([

            $userId

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getCycleStatus($userId)
{

    $cycle = $this->getLatestCycle($userId);

    if(!$cycle){

        return "Belum ada data siklus.";

    }

    $today = new DateTime();

    $nextPeriod = new DateTime(
        $cycle['next_period']
    );

    $difference = $today->diff($nextPeriod);
    if($today < $nextPeriod){
        if($difference->days <= 7){

            return "🔔 Menstruasi diperkirakan datang dalam ".$difference->days." hari.";
        }
        return "Siklus menstruasi masih berjalan.";
    }

    else{
        $late = $nextPeriod->diff($today)->days;
        return "⚠️ Menstruasi terlambat ".$late." hari.";

    }

}


}