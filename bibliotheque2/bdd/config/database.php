<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost:3306';
$dbname = 'bibliotheque2';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
    
?>
