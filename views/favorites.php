<?php
// views/favorites.php
ob_start();
?>
<h1>My Favorite Teams</h1>
<ul>
    <?php foreach ($favorites as $team): ?>
        <li>
            <a href="/teams/<?php echo $team['id']; ?>"><?php echo htmlspecialchars($team['name']); ?></a>
        </li>
    <?php endforeach; ?>
</ul>
<?php
$content = ob_get_clean();
include 'views/layout.php';
