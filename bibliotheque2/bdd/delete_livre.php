<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/database.php';



if (!isset($_GET['id'])) {
    die('Aucun ID de livre fourni.');
}
$id_livre = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
$stmt->execute([$id_livre]);
$livre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$livre) {
    die('Livre introuvable.');
}

$stmt = $pdo->prepare("DELETE FROM livres WHERE id = ?");
if ($stmt->execute([$id_livre])) {
    header("Location: index.php"); 
    exit;
} else {
    echo "Erreur lors de la suppression du livre.";
}
?>
