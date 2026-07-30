<?php

require_once __DIR__ . "/../classes/Database.php";

$db = new Database();
$conn = $db->connect();


$conn->exec("

CREATE TABLE IF NOT EXISTS users(

id INTEGER PRIMARY KEY AUTOINCREMENT,

nama TEXT NOT NULL,

email TEXT UNIQUE,

password TEXT,

created_at DATETIME DEFAULT CURRENT_TIMESTAMP

);

");


$conn->exec("

CREATE TABLE IF NOT EXISTS menstrual_cycles(

id INTEGER PRIMARY KEY AUTOINCREMENT,

user_id INTEGER NOT NULL,

start_date DATE NOT NULL,

cycle_length INTEGER NOT NULL,

period_length INTEGER NOT NULL,

next_period DATE NOT NULL,

created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(user_id) REFERENCES users(id)

);

");


$conn->exec("

CREATE TABLE IF NOT EXISTS reminders(

id INTEGER PRIMARY KEY AUTOINCREMENT,

user_id INTEGER NOT NULL,

type TEXT NOT NULL,

time TEXT NOT NULL,

status INTEGER DEFAULT 0,

created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(user_id) REFERENCES users(id)

);

");
$conn->exec("

CREATE TABLE IF NOT EXISTS daily_activities(

id INTEGER PRIMARY KEY AUTOINCREMENT,

user_id INTEGER NOT NULL,

activity_type TEXT NOT NULL,

activity_date DATE NOT NULL,

status INTEGER DEFAULT 0,

created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(user_id) REFERENCES users(id)

);

");
echo "Database berhasil dibuat.";