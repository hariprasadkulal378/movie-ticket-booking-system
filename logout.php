<?php
require_once 'config.php';

// Destroy the session to log the user out.
session_destroy();
header('Location: index.php');
exit;
?>
