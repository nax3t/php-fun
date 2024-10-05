<?php
// teams.php
function get_all_teams() {
    global $db;
    $result = $db->query("SELECT * FROM teams");
    $teams = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $teams[] = $row;
    }
    return $teams;
}

function get_team($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM teams WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    return $result->fetchArray(SQLITE3_ASSOC);
}

function add_team($name, $city, $founded) {
    global $db;
    $stmt = $db->prepare("INSERT INTO teams (name, city, founded) VALUES (:name, :city, :founded)");
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':city', $city, SQLITE3_TEXT);
    $stmt->bindValue(':founded', $founded, SQLITE3_INTEGER);
    return $stmt->execute();
}

function update_team($id, $name, $city, $founded) {
    global $db;
    $stmt = $db->prepare("UPDATE teams SET name = :name, city = :city, founded = :founded WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':city', $city, SQLITE3_TEXT);
    $stmt->bindValue(':founded', $founded, SQLITE3_INTEGER);
    return $stmt->execute();
}

function delete_team($id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM teams WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    return $stmt->execute();
}

function add_to_favorites($user_id, $team_id) {
    global $db;
    $stmt = $db->prepare("INSERT OR IGNORE INTO favorites (user_id, team_id) VALUES (:user_id, :team_id)");
    $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
    $stmt->bindValue(':team_id', $team_id, SQLITE3_INTEGER);
    return $stmt->execute();
}

function get_user_favorites($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT teams.* FROM teams JOIN favorites ON teams.id = favorites.team_id WHERE favorites.user_id = :user_id");
    $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $favorites = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $favorites[] = $row;
    }
    return $favorites;
}