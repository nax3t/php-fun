<?php
// index.php
require_once 'config.php';
require_once 'auth.php';
require_once 'teams.php';
require_once 'flash.php';

$request_uri = $_SERVER['REQUEST_URI'];
$path = trim(parse_url($request_uri, PHP_URL_PATH), '/');
$path_parts = explode('/', $path);
$action = $path_parts[0] ?? '';

switch ($action) {
    case '':
        include 'views/home.php';
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            include 'views/register.php';
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
                    try {
                        if (register($username, $password)) {
                            login($username, $password);
                            header('Location: /');
                            exit;
                        } else {
                            throw new Exception("Registration failed.");
                        }
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                        header('Location: /register');
                        exit;
                    }
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            include 'views/login.php';
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = login($username, $password);
            if ($result) {
                set_flash_message("Login successful!", "success");
                header('Location: /');
            } else {
                set_flash_message("Login failed.", "error");
                header('Location: /login');
            }
            exit();
        }
        break;

    case 'logout':
        logout();
        $_SESSION['login_message'] = "Logged out successfully.";
        header('Location: /');
        exit();
        break;

    case 'teams':
        if (isset($path_parts[1]) && $path_parts[1] == 'list') {
            $teams = get_all_teams();
            include 'views/team_list.php';
        } elseif (isset($path_parts[1]) && is_numeric($path_parts[1])) {
            $team_id = $path_parts[1];
            $team = get_team($team_id);
            include 'views/team_details.php';
        } else {
            include 'views/404.php';
        }
        break;

    case 'favorites':
        if (is_logged_in()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $team_id = $_POST['team_id'];
                $result = add_to_favorites($_SESSION['user_id'], $team_id) ? "Added to favorites!" : "Failed to add to favorites.";
                echo $result;
            } else {
                $favorites = get_user_favorites($_SESSION['user_id']);
                include 'views/favorites.php';
            }
        } else {
            include 'views/login.php';
        }
        break;

    default:
        include 'views/404.php';
        break;
}