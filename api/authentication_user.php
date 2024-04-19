<?php
session_start();
include 'dbconfig.php';

if (!isset($_SESSION['loggedinasuser']) || $_SESSION['loggedinasuser'] !== true) {
    header('Location: login.php');
    exit();
}
?>
