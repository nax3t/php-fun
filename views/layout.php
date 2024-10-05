<?php
$flash = get_flash_message();
if ($flash): ?>
    <div class="flash-message <?php echo $flash['type']; ?>">
        <?php echo htmlspecialchars($flash['message']); ?>
    </div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MLS Team Tracker</title>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <style>
    .flash-message {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }
    .flash-message.success {
        background-color: #d4edda;
        color: #155724;
    }
    .flash-message.error {
        background-color: #f8d7da;
        color: #721c24;
    }
    .flash-message.info {
        background-color: #d1ecf1;
        color: #0c5460;
    }
</style>

</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/teams/list">Teams</a>
        <?php if (is_logged_in()): ?>
            <a href="/favorites">My Favorites</a>
            <a href="/logout">Logout</a>
        <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        <?php endif; ?>
    </nav>

    <main>
        <?php echo $content; ?>
    </main>
</body>
</html></html>