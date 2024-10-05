<?php
// views/home.php
ob_start();
?>
<h1>404 - Page Not Found</h1>
<p>The page you are looking for does not exist.</p>
<a href="/">Return to Home</a>
<?php
$content = ob_get_clean();
include 'views/layout.php';