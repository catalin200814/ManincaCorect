<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];

$user_data_file = __DIR__ . '/data/user_' . $user['id'] . '_meals.json';

if (!file_exists($user_data_file)) {
    $initial_data = [
        'user_id' => $user['id'],
        'user_name' => $user['nume'],
        'weekly_plan' => [
            'Luni' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
            'Marti' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
            'Miercuri' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
            'Joi' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
            'Vineri' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
            'Sambata' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
            'Duminica' => ['mic_dejun' => '', 'pranz' => '', 'cina' => '']
        ],
        'shopping_list' => [],
        'recipes' => [
            ['id' => 1, 'name' => 'Omletă cu brânză', 'ingredients' => ['ouă', 'brânză', 'sare', 'piper']],
            ['id' => 2, 'name' => 'Salată Caesar', 'ingredients' => ['salată', 'pui', 'parmezan', 'sos Caesar']],
            ['id' => 3, 'name' => 'Paste carbonara', 'ingredients' => ['paste', 'bacon', 'ouă', 'parmezan']]
        ]
    ];
    file_put_contents($user_data_file, json_encode($initial_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $user_data = $initial_data;
} else {
    $user_data = json_decode(file_get_contents($user_data_file), true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_plan'])) {
    foreach ($_POST['meal'] as $day => $meals) {
        foreach ($meals as $meal_type => $value) {
            $user_data['weekly_plan'][$day][$meal_type] = htmlspecialchars($value);
        }
    }
    file_put_contents($user_data_file, json_encode($user_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_shopping'])) {
    $item = htmlspecialchars($_POST['shopping_item']);
    if (!empty($item)) {
        $user_data['shopping_list'][] = ['item' => $item, 'checked' => false, 'added_at' => date('Y-m-d H:i:s')];
        file_put_contents($user_data_file, json_encode($user_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_shopping'])) {
    $index = (int)$_POST['index'];
    if (isset($user_data['shopping_list'][$index])) {
        $user_data['shopping_list'][$index]['checked'] = !$user_data['shopping_list'][$index]['checked'];
        file_put_contents($user_data_file, json_encode($user_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_shopping'])) {
    $index = (int)$_POST['index'];
    if (isset($user_data['shopping_list'][$index])) {
        array_splice($user_data['shopping_list'], $index, 1);
        file_put_contents($user_data_file, json_encode($user_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PlanMeal – Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    .dashboard-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 40px 20px;
    }
    .welcome-banner {
      background: linear-gradient(135deg, #6FA043 0%, #8BC34A 100%);
      color: white;
      padding: 30px;
      border-radius: 24px;
      margin-bottom: 40px;
    }
    .welcome-banner h1 {
      margin-bottom: 10px;
    }
    .dashboard-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
    }
    .dashboard-card {
      background: white;
      border-radius: 24px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      margin-bottom: 30px;
    }
    .full-width {
      grid-column: span 2;
    }
    .card-title {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 20px;
      color: #1E1E1E;
      border-left: 4px solid #6FA043;
      padding-left: 16px;
    }
    .weekly-plan-table {
      width: 100%;
      border-collapse: collapse;
    }
    .weekly-plan-table th, .weekly-plan-table td {
      border: 1px solid #E0E0E0;
      padding: 10px;
      text-align: left;
      vertical-align: top;
    }
    .weekly-plan-table th {
      background: #F8F6F1;
      font-weight: 600;
    }
    .meal-input {
      width: 100%;
      padding: 8px;
      border: 1px solid #E0E0E0;
      border-radius: 8px;
      font-size: 13px;
    }
    .shopping-list {
      list-style: none;
      padding: 0;
    }
    .shopping-list li {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px;
      border-bottom: 1px solid #F0F0F0;
    }
    .shopping-list li.checked {
      text-decoration: line-through;
      color: #999;
    }
    .btn-sm {
      padding: 6px 12px;
      font-size: 12px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
    }
    .btn-add {
      background: #6FA043;
      color: white;
    }
    .recipes-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
    }
    .recipe-card {
      background: #F8F6F1;
      padding: 15px;
      border-radius: 16px;
    }
    .recipe-card h4 {
      margin-bottom: 10px;
      color: #6FA043;
    }
    .ingredients-list {
      font-size: 13px;
      color: #666;
    }
    .btn-save {
      margin-top: 20px;
      background: #6FA043;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      font-size: 16px;
    }
  </style>
</head>
<body>
<?php include 'php/navbar.php'; ?>

<div class="dashboard-container">
  <div class="welcome-banner">
    <h1>Bine ai venit, <?= htmlspecialchars($user['nume']) ?>! 🎉</h1>
    <p>Planifică-ți mesele săptămânale și bucură-te de gătit organizat.</p>
  </div>

  <div class="dashboard-grid">
    <div class="dashboard-card full-width">
      <h2 class="card-title">📅 Planificare săptămânală</h2>
      <form method="POST" action="">
        <table class="weekly-plan-table">
          <thead>
            <tr>
              <th>Ziua</th>
              <th>Mic dejun</th>
              <th>Prânz</th>
              <th>Cină</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($user_data['weekly_plan'] as $day => $meals): ?>
            <tr>
              <td><strong><?= $day ?></strong></td>
              <td><input type="text" name="meal[<?= $day ?>][mic_dejun]" value="<?= htmlspecialchars($meals['mic_dejun'] ?? '') ?>" class="meal-input" placeholder="Ce mănânci?"></td>
              <td><input type="text" name="meal[<?= $day ?>][pranz]" value="<?= htmlspecialchars($meals['pranz'] ?? '') ?>" class="meal-input" placeholder="Ce mănânci?"></td>
              <td><input type="text" name="meal[<?= $day ?>][cina]" value="<?= htmlspecialchars($meals['cina'] ?? '') ?>" class="meal-input" placeholder="Ce mănânci?"></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <button type="submit" name="save_plan" class="btn-save">💾 Salvează planificarea</button>
      </form>
    </div>

    <div class="dashboard-card">
      <h2 class="card-title">🛒 Listă de cumpărături</h2>
      <form method="POST" action="" style="display: flex; gap: 10px; margin-bottom: 20px;">
        <input type="text" name="shopping_item" placeholder="Adaugă un produs..." style="flex:1; padding: 10px; border-radius: 12px; border: 1px solid #E0E0E0;">
        <button type="submit" name="add_to_shopping" class="btn-sm btn-add">➕ Adaugă</button>
      </form>
      <ul class="shopping-list">
        <?php if (empty($user_data['shopping_list'])): ?>
          <li style="color: #999;">Nu ai produse în listă. Adaugă ceva!</li>
        <?php else: ?>
          <?php foreach ($user_data['shopping_list'] as $index => $item): ?>
          <li class="<?= $item['checked'] ? 'checked' : '' ?>">
            <span><?= htmlspecialchars($item['item']) ?></span>
            <div style="display: flex; gap: 8px;">
              <form method="POST" action="" style="display: inline;">
                <input type="hidden" name="index" value="<?= $index ?>">
                <button type="submit" name="toggle_shopping" class="btn-sm" style="background: #EAF3E2;">✓</button>
              </form>
              <form method="POST" action="" style="display: inline;">
                <input type="hidden" name="index" value="<?= $index ?>">
                <button type="submit" name="delete_shopping" class="btn-sm" style="background: #FFEDED;">✗</button>
              </form>
            </div>
          </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>

    <div class="dashboard-card">
      <h2 class="card-title">📖 Rețetele mele</h2>
      <div class="recipes-grid">
        <?php foreach ($user_data['recipes'] as $recipe): ?>
        <div class="recipe-card">
          <h4>🍳 <?= htmlspecialchars($recipe['name']) ?></h4>
          <div class="ingredients-list">
            <strong>Ingrediente:</strong><br>
            <?= implode(', ', $recipe['ingredients']) ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<?php include 'php/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>