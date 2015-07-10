<?php

header('Content-Type: text/cache-manifest');

session_start();
$theme = isset($_SESSION['theme'])?$_SESSION['theme']:false;

?>
CACHE MANIFEST

# Theme : <?= $theme?:'default' ?>

# This one is redundant because it's already set as fallback
theme.css

<?php if($theme) { ?>
theme/<?= $theme ?>.css
<?php } ?>

FALLBACK:
theme/ theme.css
# image/ offline.jpg

# either this
api.php api.php?offline

NETWORK:
# or this (and some JS error handling)
# api.php
