<?php ob_start(); ?>
<h1>Register</h1>
<form action="/register" method="POST">
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <button type="submit">Register</button>
    </div>
</form>
<?php
$content = ob_get_clean();
include 'views/layout.php';