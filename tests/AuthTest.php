<?php

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Create an in-memory SQLite database for testing
        $this->db = new SQLite3(':memory:');
        $this->db->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE,
            password TEXT
        )");

        // Make the database connection global so auth.php can use it
        global $db;
        $db = $this->db;

        // Include the auth.php file
        require_once __DIR__ . '/../auth.php';

        // Start a session (required for some auth functions)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function tearDown(): void
    {
        // Close the database connection
        $this->db->close();

        // Destroy the session
        session_destroy();
    }

    public function testRegistration()
    {
        $result = register('testuser', 'password123');
        $this->assertTrue($result);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', 'testuser', SQLITE3_TEXT);
        $result = $stmt->execute();
        $user = $result->fetchArray(SQLITE3_ASSOC);

        $this->assertNotNull($user);
        $this->assertEquals('testuser', $user['username']);
        $this->assertTrue(password_verify('password123', $user['password']));
    }

    public function testLogin()
    {
        register('testuser', 'password123');

        $result = login('testuser', 'password123');
        $this->assertTrue($result);
        $this->assertArrayHasKey('user_id', $_SESSION);

        $result = login('testuser', 'wrongpassword');
        $this->assertFalse($result);

        $result = login('nonexistentuser', 'password123');
        $this->assertFalse($result);
    }

    public function testIsLoggedIn()
    {
        $this->assertFalse(is_logged_in());

        $_SESSION['user_id'] = 1;
        $this->assertTrue(is_logged_in());
    }

    public function testLogout()
    {
        $_SESSION['user_id'] = 1;
        $this->assertTrue(is_logged_in());

        logout();
        $this->assertFalse(is_logged_in());
    }
}