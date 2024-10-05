<?php

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private $originalServer;

    protected function setUp(): void
    {
        $this->originalServer = $_SERVER;
    }

    protected function tearDown(): void
    {
        $_SERVER = $this->originalServer;
    }

    public function testHomeRoute()
    {
        $_SERVER['REQUEST_URI'] = '/';
        ob_start();
        include 'index.php';
        $output = ob_get_clean();
        
        $this->assertStringContainsString('Welcome to MLS Team Tracker', $output);
    }

    public function testLoginRoute()
    {
        $_SERVER['REQUEST_URI'] = '/login';
        ob_start();
        include 'index.php';
        $output = ob_get_clean();
        
        $this->assertStringContainsString('<h1>Login</h1>', $output);
    }

    public function testRegisterRoute()
    {
        $_SERVER['REQUEST_URI'] = '/register';
        ob_start();
        include 'index.php';
        $output = ob_get_clean();
        
        $this->assertStringContainsString('<h1>Register</h1>', $output);
    }

    public function testTeamsRoute()
    {
        $_SERVER['REQUEST_URI'] = '/teams';
        ob_start();
        include 'index.php';
        $output = ob_get_clean();
        
        $this->assertStringContainsString('<h1>MLS Teams</h1>', $output);
    }

    public function test404Route()
    {
        $_SERVER['REQUEST_URI'] = '/nonexistent';
        ob_start();
        include 'index.php';
        $output = ob_get_clean();
        
        $this->assertStringContainsString('404 - Page Not Found', $output);
    }
}