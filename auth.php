<?php
// auth.php
if (!session_start()) {
    // Handle the error if session_start() fails
    error_log("Failed to start session");
    // You might want to redirect to an error page or take appropriate action
    die("Error: Unable to start session");
}

function register($username, $password) {
    global $db;
    
    // Check if the username already exists
    $check_stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $check_stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $check_stmt->execute();
    $count = $result->fetchArray(SQLITE3_NUM)[0];
    
    if ($count > 0) {
        // Username already exists
        return false;
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $hashed_password, SQLITE3_TEXT);
    try {
        $result = $stmt->execute();
        if ($result === false) {
            throw new Exception("Failed to execute the statement");
        }
        return true;
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        return false;
    }
}

function login($username, $password) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function logout() {
    unset($_SESSION['user_id']);
}
