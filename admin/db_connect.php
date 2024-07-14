<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = '127.0.0.1';
$username = 'u510162695_scheduling_db';
$password = '1Scheduling_db'; // Ensure to set a proper password here
$dbname = 'u510162695_scheduling_db';
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

