<?php
require 'vendor/autoload.php';
$host = 'smart-finder-mysql-smart-finder-mahasiswa.l.aivencloud.com';
$port = '18553';
$db = 'defaultdb';
$user = 'avnadmin';
$pass = 'AVNS_3EdRPnwZ4CipxCVNtGs';

$dsn = "mysql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        // No options
    ]);
    echo "Connected without options\n";
} catch (PDOException $e) {
    echo "No options failed: " . $e->getMessage() . "\n";
}

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ]);
    echo "Connected with VERIFY_SERVER_CERT => false\n";
} catch (PDOException $e) {
    echo "VERIFY_SERVER_CERT => false failed: " . $e->getMessage() . "\n";
}

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/cert.pem', // Mac
    ]);
    echo "Connected with Mac CA\n";
} catch (PDOException $e) {
    echo "Mac CA failed: " . $e->getMessage() . "\n";
}
