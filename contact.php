<?php
session_start();
$message = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    if (empty($name) || empty($email) || empty($msg)) $error = 'Toate câmpurile sunt obligatorii.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Email invalid.';
    else {
        $file = __DIR__ . '/data/contact_messages.json';
        $messages = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        $messages[] = ['id' => count($messages)+1, 'name' => htmlspecialchars($name), 'email' => htmlspecialchars($email), 'message' => htmlspecialchars($msg), 'date' => date('Y-m-d H:i:s')];
        file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $message = 'Mesaj trimis cu succes!';
    }
}
?>
<!DOCTYPE html>
<html lang="ro"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>PlanMeal – Contact</title><link rel="stylesheet" href="css/style.css"><link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"></head>
<body><nav class="navbar"><div class="navbar-inner"><a href="index.php" class="logo"><span class="logo-icon">🍽️</span><span class="logo-text">PlanMeal</span></a><ul class="nav-links"><li><a href="index.php#features" data-translate="features">Funcționalități</a></li><li><a href="contact.php" data-translate="contact">Contact</a></li></ul><div class="nav-cta"><button id="theme-toggle" class="theme-switch">🌓</button><select id="lang-select" class="lang-switch"><option value="ro">🇷🇴 RO</option><option value="en">🇬🇧 EN</option><option value="ru">🇷🇺 RU</option></select><?php if(isset($_SESSION['user'])): ?><span>👋 <?= htmlspecialchars($_SESSION['user']['nume']) ?></span><a href="dashboard.php" class="btn-ghost" data-translate="dashboard">Dashboard</a><a href="logout.php" class="btn-primary btn-logout" data-translate="logout">Delogare</a><?php else: ?><a href="login.php" class="btn-ghost" data-translate="login">Conectare</a><a href="register.php" class="btn-primary" data-translate="register">Înregistrare</a><?php endif; ?></div></div></nav>
<div class="auth-page"><div class="auth-card" style="max-width:600px;"><div class="auth-header"><h2 data-translate="contact_title">Contactează-ne</h2><p data-translate="contact_sub">Ai întrebări? Trimite-ne un mesaj.</p></div><?php if($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?><?php if($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="POST" class="auth-form"><div class="form-group"><label data-translate="name">Nume</label><input type="text" name="name" required></div><div class="form-group"><label data-translate="email">Email</label><input type="email" name="email" required></div><div class="form-group"><label data-translate="message_label">Mesaj</label><textarea name="message" rows="5" required></textarea></div><button type="submit" class="btn-primary btn-full" data-translate="send">Trimite mesaj</button></form></div></div>
<footer class="footer">
    <div class="footer-container"><div class="footer-row"><div class="footer-col"><div class="footer-logo"><span class="footer-logo-icon">🍽️</span><span class="footer-logo-text">PlanMeal</span></div><p class="footer-tagline">Planifică inteligent. Mănâncă mai bine.</p><p class="footer-desc">Aplicația care îți transformă modul în care îți planifici mesele.</p><div class="footer-social"><a href="#" class="social-icon">📘</a><a href="#" class="social-icon">📷</a><a href="#" class="social-icon">🐦</a><a href="#" class="social-icon">🎵</a></div></div><div class="footer-col"><h4 class="footer-title">📌 Link-uri rapide</h4><ul class="footer-links-list"><li><a href="index.php#features">✨ Funcționalități</a></li><li><a href="contact.php">📧 Contact</a></li></ul></div><div class="footer-col"><h4 class="footer-title">📬 Rămâi la curent</h4><p class="footer-newsletter-text">Primește rețete săptămânale și sfaturi gratuite.</p><form class="footer-newsletter-form"><input type="email" placeholder="Email-ul tău" class="footer-input"><button type="submit" class="footer-btn">→</button></form><div class="footer-badges"><span class="badge">🍃 Fără risipă</span><span class="badge">⚡ Planificare rapidă</span></div></div></div><div class="footer-bottom"><p>© 2026 PlanMeal. Toate drepturile rezervate.</p><div class="footer-bottom-links"><a href="#">Confidențialitate</a><a href="#">Termeni</a><a href="#">Cookies</a></div></div></div>
</footer>
<script src="js/script.js"></script>
</body></html>