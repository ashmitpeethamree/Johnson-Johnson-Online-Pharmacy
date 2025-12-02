<?php
function getPDO() {
    $host = 'localhost';
    $db   = 'online_pharmacy';
    $user = 'root';
    $pass = '';
    
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
