<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/database.php';

$statement = $pdo->query("
    SELECT livres.*, 
           livres.id_auteur, 
           auteurs.nom AS auteur_nom, 
           auteurs.prenom AS auteur_prenom, 
           auteurs.date_naissance, 
           auteurs.nationalite
    FROM livres
    LEFT JOIN auteurs ON livres.id_auteur = auteurs.id
");
$livres = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>📚 Livres et auteurs</h1> |
<a href="create.php">➕ Ajouter un auteur et livre</a>
<br><br>

<table border="3" cellpadding="10">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Catégorie</th>
            <th>Auteur</th>
            <th>Date de naissance</th>
            <th>Nationalité</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($livres as $livre): ?>
        <tr>
            <td><?= htmlspecialchars($livre['titre'] ?? '') ?></td>
            <td><?= htmlspecialchars($livre['genre'] ?? '') ?></td>
            <td><?= htmlspecialchars($livre['auteur_prenom'] ?? '') ?> <?= htmlspecialchars($livre['auteur_nom'] ?? '') ?></td>
            <td><?= htmlspecialchars($livre['date_naissance'] ?? '') ?></td>
            <td><?= htmlspecialchars($livre['nationalite'] ?? '') ?></td>
            <td class="action-links">
                <a href="edit_livre.php?id=<?= $livre['id'] ?>">✏️ Modifier</a> |
                <a href="delete_livre.php?id=<?= $livre['id'] ?>" onclick="return confirm('Supprimer ce livre ?')">🗑️ Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
    // Fonction pour valider le formulaire avant soumission
    function validateLivreForm() {
        const titre = document.querySelector('input[name="titre"]').value.trim();
        const genre = document.querySelector('input[name="genre"]').value.trim();
        const auteur = document.querySelector('select[name="id_auteur"]').value;

        if (!titre || !genre || !auteur) {
            alert("Tous les champs du livre sont obligatoires.");
            return false;
        }

        if (isNaN(auteur)) {
            alert("L'ID de l'auteur doit être un nombre.");
            return false;
        }

        return true;
    }

    // Fonction de tri dynamique des colonnes du tableau
    document.addEventListener('DOMContentLoaded', function () {
        const headers = document.querySelectorAll("table th");
        headers.forEach((header, index) => {
            header.style.cursor = "pointer";
            header.addEventListener("click", () => {
                const table = header.closest("table");
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.querySelectorAll("tr"));
                const isAsc = header.classList.toggle("asc");

                rows.sort((a, b) => {
                    const aText = a.children[index].textContent.trim();
                    const bText = b.children[index].textContent.trim();
                    return isAsc
                        ? aText.localeCompare(bText)
                        : bText.localeCompare(aText);
                });

                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
</script>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
        cursor: pointer;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .action-links a {
        margin: 0 5px;
        text-decoration: none;
        padding: 4px 8px;
        border-radius: 5px;
        background-color: #3498db;
        color: white;
        font-size: 0.9em;
    }

    .action-links a.delete {
        background-color: #e74c3c;
    }

    .action-links a.edit {
        background-color: #f39c12;
    }
</style>
