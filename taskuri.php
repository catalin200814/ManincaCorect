<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo "Hello Domnisoara Adina"; ?>
    <?php echo "<script> console.log('Mesaj consola'); </script>"; ?>
    <?php
// Task-ul zilei: Par sau Impar
$numere = [12, 7, 23, 8, 15, 30, 41, 6, 19, 44];

$count_par = 0;
$count_impar = 0;

echo "<h3>Rezultatul verificării numerelor:</h3>";
echo "<ul>";

for ($i = 0; $i < count($numere); $i++) {
    if ($numere[$i] % 2 == 0) {
        echo "<li>Numărul " . $numere[$i] . " este PAR</li>";
        $count_par++;
    } else {
        echo "<li>Numărul " . $numere[$i] . " este IMPAR</li>";
        $count_impar++;
    }
}

echo "</ul>";
echo "<h4>Statistică finală:</h4>";
echo "<p>📊 Numere pare: <strong>$count_par</strong></p>";
echo "<p>📊 Numere impare: <strong>$count_impar</strong></p>";
?>
</body>
</html>