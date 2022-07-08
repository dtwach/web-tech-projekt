<?php
$con = mysqli_connect('localhost', 'root', '', 'fitnesstracker');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}