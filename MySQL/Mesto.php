<?php
session_start();

require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/Nay.php';
require_once __DIR__ . '/NayQuery.php';

$conn = DefaultConnection::getDefaultConnection();

if ($conn->connect_error) {
    die("Pripojenie k databáze zlyhalo: " . $conn->connect_error);
}

$editErr = "";
$produkty = NayQuery::create()->getAllProdukt();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if($_POST['action'] === 'save'){
        $novyNay = new Nay();
        $novyNay->mesto = $_POST['mesto'] ?? '';
        $editErr = $novyNay->save($conn);
        if (empty($editErr)) {
            echo "<script>alert('Mesto bolo úspešne uložené!'); window.location.href='Mesto.php';</script>";
            exit;
        }
    }
    
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $nay = new Nay();
        $nay->ID = $id;
        $deleteErr = NayQuery::create()->deleteProdukt($nay, $conn);
        if (empty($deleteErr)) {
            echo "<script>alert('Mesto bolo vymazané!'); window.location.href='Mesto.php';</script>";
            exit;
        }
    }
}
?>

<?php include __DIR__ . '/header.php'; ?>
<div class="form-container">
    <h2>Nový Obchod Nay</h2>

    <?php if (!empty($editErr)): ?>
        <div class="error-box">
            <?= htmlspecialchars($editErr) ?>
        </div>
    <?php endif; ?>

    <form action="Mesto.php" method="POST">
        <input type="hidden" name="action" value="save">
        <div class="form-group">
            <label for="mesto">Mesto:</label>
            <input type="text" id="mesto" name="mesto" required>
        </div>
        <button type="submit">Uložiť do databázy</button>
    </form>
</div>
<table>
    <?php foreach ($produkty as $produkt) :?> 
        <tr>
            <td><?= $produkt->ID ?></td>
            <td><?= $produkt->mesto ?></td>
            <td>
                <form action="Mesto.php" method="POST" 
                    onsubmit="return confirm('Naozaj vymazať?')">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $produkt->ID ?>">
                    <button class="delete" type="submit">Odstrániť</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
    </div> <!-- container-fluid -->
  </main>
</body>
</html>