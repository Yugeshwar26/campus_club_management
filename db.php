<?php
$host = 'localhost';
$user = 'root'; // Default XAMPP username
$pass = '';     // Default XAMPP password is empty
$dbname = 'campus_clubs'; // Ensure this matches what you typed in phpMyAdmin

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>