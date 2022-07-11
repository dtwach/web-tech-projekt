<?php
ini_set('session.gc_maxlifetime', 8 * 60 * 60);
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
}