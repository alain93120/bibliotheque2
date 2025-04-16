<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/database.php';



if (!isset($_GET['id'])) {
    die('Aucun ID d\'auteur fourni.');
}
$id_auteur = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM auteurs WHERE id = ?");
$stmt->execute([$id_auteur]);
$auteur = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($auteur);
echo "</pre>";

if (!$auteur) {
    die("Auteur introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $date_naissance = $_POST["date_naissance"];
    $nationalite = $_POST["nationalite"];

    $stmt = $pdo->prepare("UPDATE auteurs SET nom = ?, prenom = ?, date_naissance = ?, nationalite = ? WHERE id = ?");
    $stmt->execute([$nom, $prenom, $date_naissance, $nationalite, $id_auteur]);

    header("Location: index.php");
    exit;
}
?>

<h1>Modifier un auteur</h1>

<?php if (isset($message)): ?>
    <p style="color: red;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nom :<br>
        <input type="text" name="nom" value="<?= htmlspecialchars($auteur['nom']) ?>" required>
    </label><br><br>

    <label>Prénom :<br>
        <input type="text" name="prenom" value="<?= htmlspecialchars($auteur['prenom']) ?>" required>
    </label><br><br>

    <label>Date de naissance :<br>
        <input type="date" name="date_naissance" value="<?= htmlspecialchars($auteur['date_naissance']) ?>" required>
    </label><br><br>

    <label>Nationalité :<br>
        <input type="text" name="nationalite" value="<?= htmlspecialchars($auteur['nationalite']) ?>" required>
    </label><br><br>

    <button type="submit">Modifier l’auteur</button>
</form>

<br>
<a href="index.php">⬅️ Retour à l'accueil</a>
