<?php
session_start();
require_once 'Database.php';
require_once 'adminDashboard.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access denied");
}
include 'adminDashboardhtml.php';
?>