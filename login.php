<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'php/auth.php';
    $result = loginUser($_POST['email'], $_POST['parola']);
    if ($result['success']) {
        $_SESSION['user'] = $result['user'];
        header('Location: dashboard.php');
        exit;
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
  <title>PlanMeal – Conectare</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'php/navbar.php'; ?>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-header">
      <h2>Bun venit!</h2>
      <p>Conectează-te la contul tău PlanMeal</p>
    </div>
    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php" class="auth-form">
      <div class="form-group">
        <label for="email">Adresă email</label>
        <input type="email" id="email" name="email" placeholder="email@exemplu.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label for="parola">Parolă</label>
        <input type="password" id="parola" name="parola" placeholder="Parola ta" required>
      </div>
      <button type="submit" class="btn-primary btn-full">Conectează-te</button>
    </form>
    <div class="auth-footer">Nu ai cont? <a href="register.php">Înregistrează-te gratuit</a></div>
  </div>
</div>

<?php include 'php/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>