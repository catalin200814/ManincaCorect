<?php
session_start();
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
require 'php/functions.php';
$user = $_SESSION['user'];
$userData = loadUserMeals($user['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generare automată listă de cumpărături din mesele planificate
    if (isset($_POST['generate_shopping'])) {
        $itemsFile = __DIR__ . '/data/items.json';
        $recipes = [];
        if (file_exists($itemsFile)) {
            $recipes = json_decode(file_get_contents($itemsFile), true);
        }
        
        $allIngredients = [];
        foreach ($userData['weekly_plan'] as $day => $meals) {
            foreach ($meals as $mealType => $mealName) {
                if (!empty($mealName) && isset($recipes[$mealName])) {
                    foreach ($recipes[$mealName]['ingrediente'] as $ingredient) {
                        $ingredient = trim(strtolower($ingredient));
                        if (!in_array($ingredient, $allIngredients)) {
                            $allIngredients[] = $ingredient;
                        }
                    }
                }
            }
        }
        
        $newShoppingList = [];
        foreach ($allIngredients as $ingredient) {
            $newShoppingList[] = ['item' => ucfirst($ingredient), 'checked' => false];
        }
        
        $userData['shopping_list'] = $newShoppingList;
        saveUserMeals($user['id'], $userData);
        header('Location: dashboard.php'); exit;
    }
    
    if (isset($_POST['save_plan'])) {
        foreach ($_POST['meal'] as $day => $meals) {
            foreach ($meals as $type => $value) {
                $userData['weekly_plan'][$day][$type] = htmlspecialchars($value);
            }
        }
        saveUserMeals($user['id'], $userData);
        header('Location: dashboard.php'); exit;
    }
    if (isset($_POST['add_to_shopping'])) {
        $item = htmlspecialchars($_POST['shopping_item']);
        if (!empty($item)) $userData['shopping_list'][] = ['item' => $item, 'checked' => false];
        saveUserMeals($user['id'], $userData);
        header('Location: dashboard.php'); exit;
    }
    if (isset($_POST['toggle_shopping'])) {
        $idx = (int)$_POST['index'];
        if (isset($userData['shopping_list'][$idx])) $userData['shopping_list'][$idx]['checked'] = !$userData['shopping_list'][$idx]['checked'];
        saveUserMeals($user['id'], $userData);
        header('Location: dashboard.php'); exit;
    }
    if (isset($_POST['delete_shopping'])) {
        $idx = (int)$_POST['index'];
        if (isset($userData['shopping_list'][$idx])) array_splice($userData['shopping_list'], $idx, 1);
        saveUserMeals($user['id'], $userData);
        header('Location: dashboard.php'); exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>PlanMeal – Dashboard</title><link rel="stylesheet" href="css/style.css"><link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"></head>
<body>
<nav class="navbar"><div class="navbar-inner"><a href="index.php" class="logo"><span class="logo-icon">🍽️</span><span class="logo-text">PlanMeal</span></a><ul class="nav-links"><li><a href="index.php#features" data-translate="features">Funcționalități</a></li><li><a href="contact.php" data-translate="contact">Contact</a></li></ul><div class="nav-cta"><button id="theme-toggle" class="theme-switch">🌓</button><select id="lang-select" class="lang-switch"><option value="ro">🇷🇴 RO</option><option value="en">🇬🇧 EN</option><option value="ru">🇷🇺 RU</option></select><span>👋 <?= htmlspecialchars($user['nume']) ?></span><a href="logout.php" class="btn-primary btn-logout" data-translate="logout">Delogare</a></div></div></nav>
<div class="dashboard-container"><div class="welcome-banner"><h1 data-translate="welcome">Bine ai venit, <?= htmlspecialchars($user['nume']) ?>! 🎉</h1><p data-translate="welcome_desc">Planifică-ți mesele săptămânale și bucură-te de gătit organizat.</p></div>
<div class="dashboard-grid"><div class="dashboard-card full-width"><h2 data-translate="plan_weekly">📅 Planificare săptămânală</h2><form method="POST"><table class="weekly-plan-table"><thead><tr><th data-translate="day">Ziua</th><th data-translate="breakfast">Mic dejun</th><th data-translate="lunch">Prânz</th><th data-translate="dinner">Cină</th></tr></thead><tbody><?php foreach ($userData['weekly_plan'] as $day => $meals): ?><tr><td><strong><?= $day ?></strong></td><td><input type="text" name="meal[<?= $day ?>][mic_dejun]" value="<?= htmlspecialchars($meals['mic_dejun']) ?>" placeholder="Ex: omletă" class="meal-input"></td><td><input type="text" name="meal[<?= $day ?>][pranz]" value="<?= htmlspecialchars($meals['pranz']) ?>" placeholder="Ex: ciorbă" class="meal-input"></td><td><input type="text" name="meal[<?= $day ?>][cina]" value="<?= htmlspecialchars($meals['cina']) ?>" placeholder="Ex: pește" class="meal-input"></td></tr><?php endforeach; ?></tbody></table><button type="submit" name="save_plan" class="btn-save" data-translate="save">💾 Salvează planificarea</button></form></div>

<div class="dashboard-card">
    <h2 data-translate="shopping_list">🛒 Listă de cumpărături</h2>
    <form method="POST" style="margin-bottom: 20px;">
        <button type="submit" name="generate_shopping" class="btn-primary" style="width: 100%; background: #2c6e3f;">🔄 Generează automat din mesele planificate</button>
    </form>
    <form method="POST" style="display: flex; gap: 10px; margin-bottom: 20px;">
        <input type="text" name="shopping_item" placeholder="Adaugă un produs manual..." style="flex: 1; padding: 10px; border-radius: 12px; border: 1px solid #ddd;">
        <button type="submit" name="add_to_shopping" class="btn-sm btn-add">➕ Adaugă</button>
    </form>
    <ul class="shopping-list">
        <?php if(empty($userData['shopping_list'])): ?>
            <li style="color:#999;">Nu ai produse în listă. Generează automat sau adaugă manual.</li>
        <?php else: ?>
            <?php foreach($userData['shopping_list'] as $idx => $item): ?>
                <li class="<?= $item['checked'] ? 'checked' : '' ?>">
                    <span><?= htmlspecialchars($item['item']) ?></span>
                    <div>
                        <form method="POST" style="display:inline;"><input type="hidden" name="index" value="<?= $idx ?>"><button type="submit" name="toggle_shopping" class="btn-sm">✓</button></form>
                        <form method="POST" style="display:inline;"><input type="hidden" name="index" value="<?= $idx ?>"><button type="submit" name="delete_shopping" class="btn-sm btn-del">✗</button></form>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

<div class="dashboard-card"><h2 data-translate="my_recipes">📖 Rețetele mele</h2><div class="recipes-grid"><?php foreach($userData['recipes'] as $recipe): ?><div class="recipe-card"><h4>🍳 <?= htmlspecialchars($recipe['name']) ?></h4><div><strong data-translate="ingredients">Ingrediente:</strong><br><?= implode(', ', $recipe['ingredients']) ?></div></div><?php endforeach; ?></div></div></div></div>
<footer class="footer">
    <div class="footer-container"><div class="footer-row"><div class="footer-col"><div class="footer-logo"><span class="footer-logo-icon">🍽️</span><span class="footer-logo-text">PlanMeal</span></div><p class="footer-tagline">Planifică inteligent. Mănâncă mai bine.</p><p class="footer-desc">Aplicația care îți transformă modul în care îți planifici mesele.</p><div class="footer-social"><a href="#" class="social-icon">📘</a><a href="#" class="social-icon">📷</a><a href="#" class="social-icon">🐦</a><a href="#" class="social-icon">🎵</a></div></div><div class="footer-col"><h4 class="footer-title">📌 Link-uri rapide</h4><ul class="footer-links-list"><li><a href="index.php#features">✨ Funcționalități</a></li><li><a href="contact.php">📧 Contact</a></li></ul></div><div class="footer-col"><h4 class="footer-title">📬 Rămâi la curent</h4><p class="footer-newsletter-text">Primește rețete săptămânale și sfaturi gratuite.</p><form class="footer-newsletter-form"><input type="email" placeholder="Email-ul tău" class="footer-input"><button type="submit" class="footer-btn">→</button></form><div class="footer-badges"><span class="badge">🍃 Fără risipă</span><span class="badge">⚡ Planificare rapidă</span></div></div></div><div class="footer-bottom"><p>© 2026 PlanMeal. Toate drepturile rezervate.</p><div class="footer-bottom-links"><a href="#">Confidențialitate</a><a href="#">Termeni</a><a href="#">Cookies</a></div></div></div>
</footer>
<script src="js/script.js"></script>
</body>
</html>