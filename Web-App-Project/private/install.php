<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'webdev';

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a new database
$createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($createDatabaseQuery) === false) {
    die("Error creating database: " . $conn->error);
}

// Select the newly created database
$conn->select_db($database);

// Read the SQL file
$sqlFile = '../data/webdev.sql';
$sql = file_get_contents($sqlFile);

// Execute the SQL statements
if ($conn->multi_query($sql) === false) {
    die("Error creating table: " . $conn->error);
}

echo "SUCCESS: Database and table created successfully";

// Close the connection
$conn->close();
