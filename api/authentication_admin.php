<?php
session_start();
include 'dbconfig.php';

if (!isset($_SESSION['loggedinasadmin']) || $_SESSION['loggedinasadmin'] !== true) {
    header('Location: login.php');
    exit();
}
?>
