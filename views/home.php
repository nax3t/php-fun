<?php
// views/home.php
ob_start();
?>
<h1>Welcome to MLS Team Tracker</h1>
<p>Use this application to explore MLS teams and keep track of your favorites!</p>
<ul>
    <li><a href="index.php?action=list_teams">View all teams</a></li>
    <?php if (is_logged_in()): ?>
        <li><a href="index.php?action=view_favorites">View your favorite teams</a></li>
    <?php else: ?>
        <li><a href="/login">Log in to manage your favorites</a></li>
    <?php endif; ?>
</ul>
<?php
$content = ob_get_clean();
include 'views/layout.php';