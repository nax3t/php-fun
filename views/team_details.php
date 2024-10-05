<?php
// views/team_details.php
ob_start();
?>
<h1><?php echo htmlspecialchars($team['name']); ?></h1>
<p>City: <?php echo htmlspecialchars($team['city']); ?></p>
<p>Founded: <?php echo htmlspecialchars($team['founded']); ?></p>

<?php if (is_logged_in()): ?>
    <form hx-post="/favorites" hx-swap="outerHTML">
        <input type="hidden" name="team_id" value="<?php echo $team['id']; ?>">
        <button type="submit">Add to Favorites</button>
    </form>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'views/layout.php';
