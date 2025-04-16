<?php
require_once __DIR__ . '/config/database.php';

if ($pdo) {
    echo "✅ Connexion à la base de données réussie !";
} else {
    echo "❌ Échec de la connexion.";
}
