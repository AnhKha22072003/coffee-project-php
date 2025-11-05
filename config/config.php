<?php

try {
    //host
    define('HOST', 'localhost');

    //database name
    define('DB_NAME', 'coffee-blend222');

    //database username
    define('DB_USER', 'root');

    //database password
    define('DB_PASSWORD', '');

    $conn = new PDO('mysql:host=' . HOST . ';port=3307;dbname=' . DB_NAME . "", DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}