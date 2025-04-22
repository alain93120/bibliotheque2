<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require_once __DIR__ . '/config/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['email'], $_POST['password'])) {
  
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  
  $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
  $stmt = $pdo->prepare($query);

  try {
    $stmt->execute([
      ':username' => $username,
      ':email' => $email,
      ':password' => $hashed_password
    ]);
    echo "<div class='success'>
            <h3>✅ Vous êtes inscrit avec succès.</h3>
            <p>Cliquez ici pour vous <a href='login.php'>connecter</a></p>
          </div>";
  } catch (PDOException $e) {
    echo "<div class='error'>
            <p>❌ Erreur : " . $e->getMessage() . "</p>
          </div>";
  }

} else {
?>

<form class="box" action="" method="post">
  <h1 class="box-title">S'inscrire</h1>
  <input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur" required />
  <input type="email" class="box-input" name="email" placeholder="Email" required />
  <input type="password" class="box-input" name="password" placeholder="Mot de passe" required />
  <input type="submit" name="submit" value="S'inscrire" class="box-button" />
  <p class="box-register">Déjà inscrit ? <a href="login.php">Connectez-vous ici</a></p>
</form>

<?php } ?>
</body>
</html>
