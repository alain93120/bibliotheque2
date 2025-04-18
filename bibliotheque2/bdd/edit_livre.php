<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/database.php';

if (!isset($_GET['id'])) {
    die('Aucun ID de livre fourni.');
}

$id_livre = $_GET['id'];

// Récupérer les infos du livre
$stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
$stmt->execute([$id_livre]);
$livre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$livre) {
    die("Livre introuvable.");
}

// Récupérer les auteurs
$statement = $pdo->query("SELECT * FROM auteurs");
$auteurs = $statement->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = trim($_POST["titre"]);
    $genre = trim($_POST["genre"]);
    $id_auteur = trim($_POST["id_auteur"]);

    // Validation basique
    if (empty($titre) || empty($genre) || empty($id_auteur)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!is_numeric($id_auteur)) {
        $message = "L'ID de l'auteur n'est pas valide.";
    } else {
        $date_edition = date('Y-m-d');
        $stmt = $pdo->prepare("UPDATE livres SET titre = ?, genre = ?, id_auteur = ?, date_edition = ? WHERE id = ?");
        if ($stmt->execute([$titre, $genre, $id_auteur, $date_edition, $id_livre])) {
            header("Location: index.php");
            exit;
        } else {
            $message = "Erreur lors de la mise à jour du livre.";
        }
    }
}
?>

<h1>✏️ Modifier un livre</h1>

<?php if (isset($message)): ?>
    <p style="color: red;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST" onsubmit="return validateLivreForm();">
    <label>Titre :<br>
        <input type="text" name="titre" value="<?= htmlspecialchars($livre['titre'] ?? '') ?>" required>
    </label><br><br>

    <label>Catégorie :<br>
        <input type="text" name="genre" value="<?= htmlspecialchars($livre['genre'] ?? '') ?>" required>
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
echo '<br>Livres ID: ' . htmlspecialchars($id_livre);
?>
