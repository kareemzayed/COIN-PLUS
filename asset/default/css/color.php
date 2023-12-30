<?php

header("Content-Type:text/css");

$primary_color = '#' . $_GET['primary_color'];
?>

:root {
    --main-color: <?php echo $primary_color; ?>;
}
.cookie-modal {
    background-color: <?php echo $primary_color; ?> !important;
}