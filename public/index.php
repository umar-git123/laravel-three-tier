<?php
$host = getenv('DB_HOST') ?: 'mysql-service';
$db   = getenv('DB_DATABASE') ?: 'laravel_db';
$user = getenv('DB_USERNAME') ?: 'laravel_user';
$pass = getenv('DB_PASSWORD') ?: 'userpassword123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $status = "Connected successfully to MySQL!";
} catch (PDOException $e) {
    $status = "Database Connection Failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head><title>Laravel Three-Tier App</title></head>
<body style="font-family: Arial; text-align: center; margin-top: 10%;">
    <h1>Laravel Three-Tier Architecture</h1>
    <p><strong>Presentation Tier:</strong> Nginx Reverse Proxy</p>
    <p><strong>Application Tier:</strong> PHP 8.2-FPM</p>
    <p><strong>Database Tier:</strong> MySQL Service</p>
    <hr style="width: 50%;">
    <h2>Status: <?= $status ?></h2>
</body>
</html>
