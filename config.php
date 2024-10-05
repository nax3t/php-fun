<?php
// config.php
$db = new SQLite3('mls_teams.db');

// Create tables
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS teams (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    city TEXT,
    founded INTEGER
)");

$db->exec("CREATE TABLE IF NOT EXISTS favorites (
    user_id INTEGER,
    team_id INTEGER,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (team_id) REFERENCES teams(id),
    PRIMARY KEY (user_id, team_id)
)");