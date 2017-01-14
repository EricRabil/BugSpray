<?php
$signedIn = $_SESSION['user']['session_active'];
render("index.phtml", "BugSpray", $context = array(), $styles = array(), $scripts = array(), "HS::Home");
?>
