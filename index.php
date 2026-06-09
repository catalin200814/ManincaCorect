<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlanMeal – Planifică inteligent. Mănâncă mai bine.</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <div class="navbar-inner">
        <a href="index.php" class="logo">
            <span class="logo-icon">🍽️</span>
            <span class="logo-text">PlanMeal</span>
        </a>
        <ul class="nav-links">
            <li><a href="#features" data-translate="features">Funcționalități</a></li>
            <li><a href="contact.php" data-translate="contact">Contact</a></li>
        </ul>
        <div class="nav-cta">
            <button id="theme-toggle" class="theme-switch">🌓</button>
            <select id="lang-select" class="lang-switch">
                <option value="ro">🇷🇴 RO</option>
                <option value="en">🇬🇧 EN</option>
                <option value="ru">🇷🇺 RU</option>
            </select>
            <?php if (isset($_SESSION['user'])): ?>
                <span class="user-greeting">👋 <?= htmlspecialchars($_SESSION['user']['nume']) ?></span>
                <a href="dashboard.php" class="btn-ghost" data-translate="dashboard">Dashboard</a>
                <a href="logout.php" class="btn-primary btn-logout" data-translate="logout">Delogare</a>
            <?php else: ?>
                <a href="login.php" class="btn-ghost" data-translate="login">Conectare</a>
                <a href="register.php" class="btn-primary" data-translate="register">Înregistrare</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">✨ AI + Planificare inteligentă</div>
        <h1>
            <span data-translate="hero_title1">Planifică</span> 
            <span class="highlight" data-translate="hero_title2">inteligent.</span><br>
            <span data-translate="hero_title3">Mănâncă mai bine.</span>
        </h1>
        <p class="hero-desc" data-translate="hero_desc">
            Planifică mesele săptămânale în câteva minute și primești automat lista de cumpărături. 
            Economisești timp, bani și mănânci sănătos fără stres.
        </p>
        <div class="hero-buttons">
            <a href="register.php" class="btn-hero btn-hero-primary" data-translate="start_now">Începe acum</a>
            <a href="#features" class="btn-hero btn-hero-secondary" data-translate="learn_more">Află mai multe</a>
        </div>
        <div class="hero-stats">
            <div class="stat"><span class="stat-number">5000+</span> <span data-translate="stat_users">utilizatori activi</span></div>
            <div class="stat"><span class="stat-number">10k+</span> <span data-translate="stat_meals">mese planificate</span></div>
            <div class="stat"><span class="stat-number">30%</span> <span data-translate="stat_savings">timp economisit</span></div>
        </div>
    </div>
    <div class="hero-visual">
        <div class="preview-card-glass">
            <div class="preview-header">📅 <span data-translate="weekly_plan">Plan săptămânal</span></div>
            <div class="preview-meal">🍗 <span data-translate="monday">Luni</span>: Piept de pui cu quinoa</div>
            <div class="preview-meal">🥗 <span data-translate="tuesday">Marți</span>: Salată cu avocado</div>
            <div class="preview-meal">🐟 <span data-translate="wednesday">Miercuri</span>: Somon la cuptor</div>
            <div class="preview-meal">🥑 <span data-translate="thursday">Joi</span>: Buddha bowl</div>
            <div class="preview-footer">🛒 <span data-translate="auto_list">Listă automată generată</span></div>
        </div>
    </div>
</section>

<section class="features" id="features">
    <div class="section-header">
        <span class="section-tag" data-translate="what_we_offer">Ce oferim</span>
        <h2 data-translate="features_title">Funcționalități principale</h2>
        <p data-translate="features_subtitle">Tot ce ai nevoie pentru o alimentație organizată și sănătoasă</p>
    </div>
    <div class="features-grid">
        <div class="feature-card"><div class="feature-icon">📅</div><h3 data-translate="plan_weekly">Planificare săptămânală</h3><p data-translate="plan_desc">Organizează mesele pe zile și tipuri de masă</p></div>
        <div class="feature-card"><div class="feature-icon">🛒</div><h3 data-translate="shopping_list">Listă cumpărături automată</h3><p data-translate="shopping_desc">Generează instant lista pe baza rețetelor</p></div>
        <div class="feature-card"><div class="feature-icon">💰</div><h3 data-translate="savings">Economii & Reducere risipă</h3><p data-translate="savings_desc">Planifică inteligent și cheltuie mai puțin</p></div>
        <div class="feature-card"><div class="feature-icon">📖</div><h3 data-translate="my_recipes">Rețete personale</h3><p data-translate="recipes_desc">Salvează și gestionează rețetele tale preferate</p></div>
    </div>
</section>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-row">
            <div class="footer-col">
                <div class="footer-logo">
                    <span class="footer-logo-icon">🍽️</span>
                    <span class="footer-logo-text">PlanMeal</span>
                </div>
                <p class="footer-tagline" data-translate="footer_tagline">Planifică inteligent. Mănâncă mai bine.</p>
                <p class="footer-desc">Aplicația care îți transformă modul în care îți planifici mesele. Simplu, rapid și eficient.</p>
                <div class="footer-social">
                    <a href="#" class="social-icon" aria-label="Facebook">📘</a>
                    <a href="#" class="social-icon" aria-label="Instagram">📷</a>
                    <a href="#" class="social-icon" aria-label="Twitter">🐦</a>
                    <a href="#" class="social-icon" aria-label="TikTok">🎵</a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">📌 Link-uri rapide</h4>
                <ul class="footer-links-list">
                    <li><a href="#features" data-translate="features">✨ Funcționalități</a></li>
                    <li><a href="contact.php" data-translate="contact">📧 Contact</a></li>
                    <li><a href="#">📖 Blog</a></li>
                    <li><a href="#">❓ FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">📬 Rămâi la curent</h4>
                <p class="footer-newsletter-text">Primește rețete săptămânale și sfaturi gratuite.</p>
                <form class="footer-newsletter-form" method="POST">
                    <input type="email" placeholder="Email-ul tău" required class="footer-input">
                    <button type="submit" class="footer-btn">→</button>
                </form>
                <div class="footer-badges">
                    <span class="badge">🍃 Fără risipă</span>
                    <span class="badge">⚡ Planificare rapidă</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 PlanMeal. <span data-translate="all_rights">Toate drepturile rezervate.</span></p>
            <div class="footer-bottom-links">
                <a href="#">Confidențialitate</a>
                <a href="#">Termeni</a>
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>
</footer>
<script src="js/script.js"></script>
</body>
</html>