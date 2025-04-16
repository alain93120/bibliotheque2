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
            <td><?= htmlspecialchars($livre['titre']) ?></td>
            <td><?= htmlspecialchars($livre['genre']) ?></td>
            <td><?= htmlspecialchars($livre['auteur_prenom'] . ' ' . $livre['auteur_nom']) ?></td>
            <td><?= htmlspecialchars($livre['date_naissance']) ?></td>
            <td><?= htmlspecialchars($livre['nationalite']) ?></td>
            <td>
                <a href="edit_livre.php?id=<?= $livre['id'] ?>">✏️ Modifier</a> |
                <a href="edit_auteur.php?id=<?= $livre['id_auteur'] ?>">✏️ Modifier l’auteur</a>
                <a href="delete_livre.php?id=<?= $livre['id'] ?>" onclick="return confirm('Supprimer ce livre ?')">🗑️ Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
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
