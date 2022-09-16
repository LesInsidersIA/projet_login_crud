<?php
// On initialiser une session
session_start();

// On deconnecter tous les var
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
