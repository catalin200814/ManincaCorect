<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PlanMeal</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'php/navbar.php'; ?>
<section class="hero">
  <div class="hero-left">
    <div class="hero-badge"><span class="dot"></span>Planificare simplă și inteligentă</div>
    <h1>Planifică <em>inteligent.</em><br>Mănâncă mai bine.</h1>
    <p class="hero-sub">Planifică mesele săptămânale în câteva minute și primești automat lista de cumpărături.</p>
    <ul class="benefits">
      <li class="benefit-item"><div class="benefit-icon">📅</div><span>Planifici rapid mesele pentru întreaga săptămână</span></li>
      <li class="benefit-item"><div class="benefit-icon">🛒</div><span>Listă de cumpărături generată automat</span></li>
      <li class="benefit-item"><div class="benefit-icon">⏱️</div><span>Economisești timp, bani și reduci risipa alimentară</span></li>
    </ul>
    <div class="hero-buttons">
      <a href="register.php" class="btn-hero btn-hero-primary">Începe gratuit</a>
      <a href="#features" class="btn-hero btn-hero-secondary">▶ Vezi cum funcționează</a>
    </div>
  </div>
  <div class="hero-right">
    <div class="planner-preview">
      <div class="planner-header">
        <div class="planner-title">Planificator săptămânal</div>
        <div class="planner-week">20 – 26 Mai 2024</div>
      </div>
      <div class="days-row">
        <div></div>
        <div class="day-label">Lun</div>
        <div class="day-label">Mar</div>
        <div class="day-label">Mie</div>
        <div class="day-label">Joi</div>
        <div class="day-label">Vin</div>
        <div class="day-label">Sâm</div>
        <div class="day-label">Dum</div>
      </div>
      <div class="meal-grid">
        <div class="row-label">Mic dejun</div>
        <div class="meal-cell filled">🥣</div>
        <div class="meal-cell">🍳</div>
        <div class="meal-cell filled">🥛</div>
        <div class="meal-cell">🥤</div>
        <div class="meal-cell filled">🥑</div>
        <div class="meal-cell empty-slot"><span class="plus">+</span></div>
        <div class="meal-cell empty-slot"><span class="plus">+</span></div>
        <div class="row-label">Prânz</div>
        <div class="meal-cell">🥗</div>
        <div class="meal-cell filled">🍝</div>
        <div class="meal-cell">🍲</div>
        <div class="meal-cell filled">🌾</div>
        <div class="meal-cell">🐟</div>
        <div class="meal-cell empty-slot"><span class="plus">+</span></div>
        <div class="meal-cell empty-slot"><span class="plus">+</span></div>
        <div class="row-label">Cină</div>
        <div class="meal-cell filled">🥘</div>
        <div class="meal-cell">🍗</div>
        <div class="meal-cell">🍖</div>
        <div class="meal-cell filled">🥦</div>
        <div class="meal-cell">🍕</div>
        <div class="meal-cell empty-slot"><span class="plus">+</span></div>
        <div class="meal-cell empty-slot"><span class="plus">+</span></div>
      </div>
    </div>
  </div>
</section>
<section class="features" id="features">
  <div class="section-header">
    <div class="section-tag">Funcționalități</div>
    <h2>Tot ce ai nevoie într-o singură aplicație</h2>
  </div>
  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon-wrap">📅</div>
      <div class="feature-title">Planificare ușoară</div>
      <p class="feature-desc">Adaugi mesele preferate și le organizezi pe zile, exact cum îți dorești.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon-wrap">🛒</div>
      <div class="feature-title">Listă automată</div>
      <p class="feature-desc">Se generează instant pe baza rețetelor și porțiilor alese.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon-wrap">🥗</div>
      <div class="feature-title">Rețete sănătoase</div>
      <p class="feature-desc">Descoperă rețete delicioase, filtrate după preferințele tale alimentare.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon-wrap">💰</div>
      <div class="feature-title">Economisești</div>
      <p class="feature-desc">Eviți cumpărăturile în plus și reduci risipa alimentară.</p>
    </div>
  </div>
</section>
<section class="promo-wrap" id="promo">
  <div class="promo">
    <div class="promo-left">
      <h2>Gătit planificat.<br><em>Viață simplificată.</em></h2>
      <p class="promo-desc">Începe să planifici mesele și să te bucuri de mai mult timp pentru tine și cei dragi.</p>
      <a href="register.php" class="btn-primary">Începe gratuit →</a>
      <div class="stats-stack">
        <div class="stat-card"><div class="stat-num">2h+</div><div class="stat-label">Timp economisit săptămânal</div></div>
        <div class="stat-card"><div class="stat-num">20%</div><div class="stat-label">Economii la cumpărături</div></div>
        <div class="stat-card"><div class="stat-num">♻️</div><div class="stat-label">Mai puțină risipă alimentară</div></div>
      </div>
    </div>
    <div class="promo-right">
      <div class="promo-image">🥗</div>
    </div>
  </div>
</section>
<?php include 'php/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>