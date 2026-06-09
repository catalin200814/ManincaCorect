<?php
session_start();
if (isset($_SESSION['user'])) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'php/auth.php';
    $result = loginUser($_POST['email'], $_POST['parola']);
    if ($result['success']) { $_SESSION['user'] = $result['user']; header('Location: dashboard.php'); exit; }
    else $error = $result['message'];
}
?>
<!DOCTYPE html>
<html lang="ro">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>PlanMeal – Conectare</title><link rel="stylesheet" href="css/style.css"><link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"></head>
<body>
<nav class="navbar"><div class="navbar-inner"><a href="index.php" class="logo"><span class="logo-icon">🍽️</span><span class="logo-text">PlanMeal</span></a><div class="nav-cta"><button id="theme-toggle" class="theme-switch">🌓</button><a href="register.php" class="btn-primary">Înregistrare</a></div></div></nav>
<div class="auth-page"><div class="auth-card"><div class="auth-header"><h2>Bun venit!</h2><p>Conectează-te la contul tău PlanMeal</p></div><?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="POST" class="auth-form"><div class="form-group"><label>Email</label><input type="email" name="email" required></div><div class="form-group"><label>Parolă</label><input type="password" name="parola" required></div><button type="submit" class="btn-primary btn-full">Conectează-te</button></form><div class="auth-footer">Nu ai cont? <a href="register.php">Înregistrează-te gratuit</a></div></div></div>
<footer class="footer">
    <div class="footer-container"><div class="footer-row"><div class="footer-col"><div class="footer-logo"><span class="footer-logo-icon">🍽️</span><span class="footer-logo-text">PlanMeal</span></div><p class="footer-tagline">Planifică inteligent. Mănâncă mai bine.</p><p class="footer-desc">Aplicația care îți transformă modul în care îți planifici mesele.</p><div class="footer-social"><a href="#" class="social-icon">📘</a><a href="#" class="social-icon">📷</a><a href="#" class="social-icon">🐦</a><a href="#" class="social-icon">🎵</a></div></div><div class="footer-col"><h4 class="footer-title">📌 Link-uri rapide</h4><ul class="footer-links-list"><li><a href="index.php#features">✨ Funcționalități</a></li><li><a href="contact.php">📧 Contact</a></li></ul></div><div class="footer-col"><h4 class="footer-title">📬 Rămâi la curent</h4><p class="footer-newsletter-text">Primește rețete săptămânale și sfaturi gratuite.</p><form class="footer-newsletter-form"><input type="email" placeholder="Email-ul tău" class="footer-input"><button type="submit" class="footer-btn">→</button></form><div class="footer-badges"><span class="badge">🍃 Fără risipă</span><span class="badge">⚡ Planificare rapidă</span></div></div></div><div class="footer-bottom"><p>© 2026 PlanMeal. Toate drepturile rezervate.</p><div class="footer-bottom-links"><a href="#">Confidențialitate</a><a href="#">Termeni</a><a href="#">Cookies</a></div></div></div>
</footer>
<script src="js/script.js"></script>
</body>
</html>