<?php
session_start();
ini_set('session.gc_maxlifetime', 8 * 60 * 60);
if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
}