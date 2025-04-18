<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajouter_auteur'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $date_naissance = $_POST['date_naissance'] ?? null;
    $nationalite = $_POST['nationalite'] ?? null;

    if (!empty($nom) && !empty($prenom)) {
        $stmt = $pdo->prepare("INSERT INTO auteurs (nom, prenom, date_naissance, nationalite) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $date_naissance, $nationalite]);
        $message = "Auteur ajouté avec succès.";
    } else {
        $message = "Veuillez remplir tous les champs obligatoires de l'auteur.";
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajouter_livre'])) {
    $titre = trim($_POST["titre"]);
    $genre = trim($_POST["genre"]);
    $id_auteur = $_POST["id_auteur"];

    if (empty($titre) || empty($genre) || empty($id_auteur)) {
        $message = "Tous les champs sont obligatoires pour le livre.";
    } elseif (!is_numeric($id_auteur)) {
        $message = "L'ID de l'auteur est invalide.";
    } else {
        $date_edition = date('Y-m-d');
        $stmt = $pdo->prepare("INSERT INTO livres (titre, genre, id_auteur, date_edition) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titre, $genre, $id_auteur, $date_edition]);
        header("Location: index.php");
        exit;
    }
}

$statement = $pdo->query("SELECT * FROM auteurs");
$auteurs = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>➕ Ajouter un auteur et un livre</h1>

<?php if (!empty($message)): ?>
    <p style="color: red;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<h2>Ajouter un auteur</h2>
<form method="POST">
    <label>Nom :<br>
        <input type="text" name="nom" required>
    </label><br><br>

    <label>Prénom :<br>
        <input type="text" name="prenom" required>
    </label><br><br>

    <label>Date de naissance :<br>
        <input type="date" name="date_naissance">
    </label><br><br>

    <label>Nationalité :<br>
        <input type="text" name="nationalite">
    </label><br><br>

    <button type="submit" name="ajouter_auteur">Ajouter l'auteur</button>
</form>

<h2>Ajouter un livre</h2>
<form method="POST">
    <label>Titre :<br>
        <input type="text" name="titre" required>
    </label><br><br>

    <label>Catégorie :<br>
        <input type="text" name="genre" required>
    </label><br><br>

    <label>Auteur :<br>
        <select name="id_auteur" required>
            <option value="">-- Sélectionner un auteur --</option>
            <?php foreach ($auteurs as $auteur): ?>
                <option value="<?= $auteur['id'] ?>">
                    <?= htmlspecialchars($auteur['prenom'] . ' ' . $auteur['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <button type="submit" name="ajouter_livre">Ajouter le livre</button>
</form>

<br>
<a href="index.php">⬅️ Retour à l'accueil</a>
