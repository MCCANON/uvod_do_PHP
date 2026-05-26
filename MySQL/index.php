<?php
session_start();

require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/Mobily.php';
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/MobilyQuery.php';
require_once __DIR__ . '/Nay.php';
require_once __DIR__ . '/NayQuery.php';

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
        $novyMobil->nay_ID = (int)($_POST['nay_ID'] ?? 0);
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
    if($_POST['action'] === 'edit' && isset($_POST['id'])){
        $id = (int)$_POST['id'];
        $_SESSION['edit_id'] = $id;
        header("Location: editIndex.php");
        exit;
    }
}

?>

<?php include __DIR__ . '/header.php'; ?>
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
        <div class="form-group">
    <label for="nay_ID">Obchod Nay:</label>
    <select id="nay_ID" name="nay_ID" required>
        <?php foreach (NayQuery::create()->getAllProdukt() as $nay): ?>
            <option value="<?= $nay->ID ?>"><?= $nay->mesto ?></option>
        <?php endforeach; ?>
    </select>
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
                <td data-name="nay_ID" class="product-nay_ID"><?= $produkt->mesto?></td>
                <td>
                    <form action="index.php" method="POST" 
                        onsubmit="return confirm('Naozaj vymazať?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $produkt->ID ?>">
                        <button class ="delete"type="submit">Odstrániť</button>
                    </form>
                </td>
                <td>
                    <form action="index.php" method="POST" 
                        onsubmit="return confirm('Upraviť tento mobil?')">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?= $produkt->ID ?>">
                        <button class ="edit"type="submit">Upraviť</button>
                    </form>
                </td>
            </tr>
            
    <?php endforeach; ?>
</table>
    </div> <!-- container-fluid -->
  </main>
</body>
</html>