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

$statement = $pdo->query("SELECT * FROM auteurs");
$auteurs = $statement->fetchAll(PDO::FETCH_ASSOC);

if (!$livre) {
    die("Livre introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST["titre"];
    $genre = $_POST["genre"];
    $id_auteur = $_POST["id_auteur"];

    var_dump($_POST);

    if (!empty($titre) && !empty($genre) && !empty($id_auteur)) {
        $stmt = $pdo->prepare("UPDATE livres SET titre = ?, genre = ?, id_auteur = ? WHERE id = ?");
        
        if ($stmt->execute([$titre, $genre, $id_auteur, $id_livre])) {
            header("Location: index.php"); 
            exit;
        } else {
            $message = "Erreur lors de la mise à jour du livre.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<h1>✏️ Modifier un livre</h1>

<?php if (isset($message)): ?>
    <p style="color: red;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Titre :<br>
        <input type="text" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>
    </label><br><br>

    <label>Catégorie :<br>
        <input type="text" name="genre" value="<?= htmlspecialchars($livre['genre']) ?>" required>
    </label><br><br>

    <label>Auteur :<br>
        <select name="id_auteur" required>
            <option value="">-- Sélectionner un auteur --</option>
            <?php foreach ($auteurs as $auteur): ?>
                <option value="<?= $auteur['id'] ?>" <?= $livre['id_auteur'] == $auteur['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($auteur['prenom'] . ' ' . $auteur['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <button type="submit">Modifier le livre</button>
</form>

<br>
<a href="index.php">⬅️ Retour à l'accueil</a>

<?php
echo '<br>Livres ID: ' . $id_livre;
?>
