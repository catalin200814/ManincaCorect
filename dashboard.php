<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PlanMeal – Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'php/navbar.php'; ?>

<div class="auth-page">
  <div class="auth-card" style="max-width: 600px; text-align: center;">
    <h2>Bine ai venit, <?= htmlspecialchars($user['nume']) ?>! 🎉</h2>
    <p>Ești autentificat cu succes în contul PlanMeal.</p>
    <p style="margin-top: 20px;">Aici va veni conținutul aplicației tale (planificator mese, rețete, etc.).</p>
    <a href="logout.php" class="btn-primary" style="background: #c0392b; margin-top: 30px; display: inline-block;">Delogare</a>
  </div>
</div>

<?php include 'php/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>