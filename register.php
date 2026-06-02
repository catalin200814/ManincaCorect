<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'php/auth.php';
    $result = registerUser($_POST['nume'], $_POST['email'], $_POST['parola'], $_POST['confirma']);
    if ($result['success']) {
        $success = $result['message'];
    } else {
        $error = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PlanMeal – Înregistrare</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'php/navbar.php'; ?>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-header">
      <h2>Creează cont</h2>
      <p>Începe să planifici mesele săptămânale</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?> <a href="login.php">Conectează-te</a></div>
    <?php endif; ?>

    <form method="POST" action="register.php" class="auth-form">
      <div class="form-group">
        <label for="nume">Nume complet</label>
        <input type="text" id="nume" name="nume" placeholder="Ex: Ion Popescu"
               value="<?= htmlspecialchars($_POST['nume'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label for="email">Adresă email</label>
        <input type="email" id="email" name="email" placeholder="email@exemplu.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label for="parola">Parolă</label>
        <input type="password" id="parola" name="parola" placeholder="Minim 6 caractere" required>
        <span class="input-hint">Minim 6 caractere</span>
      </div>

      <div class="form-group">
        <label for="confirma">Confirmă parola</label>
        <input type="password" id="confirma" name="confirma" placeholder="Repetă parola" required>
      </div>

      <button type="submit" class="btn-primary btn-full">Creează cont gratuit</button>
    </form>

    <div class="auth-footer">
      Ai deja cont? <a href="login.php">Conectează-te</a>
    </div>
  </div>
</div>

<?php include 'php/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>