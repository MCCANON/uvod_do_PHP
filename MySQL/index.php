<?php

include "DB.php";
require_once __DIR__ . '/Mobily.php'; 
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/MobilyQuery.php';

$conn = DefaultConnection::getDefaultConnection();

if ($conn->connect_error) {
    die("Pripojenie k databáze zlyhalo: " . $conn->connect_error);
}

$editErr = "";
$produkty = MobilyQuery::create()->getAllProdukt();

// 3. Spracovanie odoslaného formulára
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if($_POST['action'] === 'save'){
    
        $novyMobil = new Mobily();
        $novyMobil->nazov = $_POST['nazov'] ?? '';
        $novyMobil->model = $_POST['model'] ?? '';
        $novyMobil->cena = (float)($_POST['cena'] ?? 0.0);
        $editErr = $novyMobil->save($conn);
        if (empty($editErr)) {
            echo "<script>alert('Mobil bol úspešne uložený!'); window.location.href='index.php';</script>";
            exit;
        }
    }
    
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
    
        $mobil = new Mobily();
        $mobil->ID = $id;
    
        $deleteErr = MobilyQuery::create()->deleteProdukt($mobil, $conn);
        
        if (empty($deleteErr)) {
            echo "<script>alert('Mobil bol vymazaný!'); window.location.href='index.php';</script>";
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Správa Mobilov</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 40px; }
        .form-container { max-width: 450px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 0 auto; }
        h2 { margin-top: 0; color: #333; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; background-color: #007bff; color: white; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.2s; }
        button:hover { background-color: #0056b3; }
        .error-box { background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb; font-weight: bold; }
        table { max-width: 700px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 0 auto; margin-top: 30px; width: 80%; font-weight: bold; }
        .delete { background-color: #dc3545; }
        button.delete:hover { background-color: #ae1f2d; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Nový Mobil</h2>

    <?php if (!empty($editErr)): ?>
        <div class="error-box">
            <?= htmlspecialchars($editErr) ?>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="save">

        <div class="form-group">
            <label for="nazov">Názov:</label>
            <input type="text" id="nazov" name="nazov" required>
        </div>

        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required>
        </div>

        <div class="form-group">
            <label for="cena">Cena (€):</label>
            <input type="number" step="0.01" id="cena" name="cena" required>
        </div>

        <button type="submit">Uložiť do databázy</button>
    </form>
</div>
<table>
    <?php foreach ($produkty as $produkt) :?> 
            <tr>
                <td data-name="nazov_produktu" class="product-nazov"><?= $produkt->nazov?></td>
                <td data-name="model" class="product-model"><?= $produkt->model?></td>
                <td data-name="cena" class="product-cena"><?= $produkt->cena?>€</td>
                <td>
                    <form action="index.php" method="POST" 
                        onsubmit="return confirm('Naozaj vymazať?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $produkt->ID ?>">
                        <button class ="delete"type="submit">Odstrániť</button>
                    </form>
                </td>
            </tr>
            
    <?php endforeach; ?>
</table>
</body>
</html>