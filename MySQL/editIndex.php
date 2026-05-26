<?php
session_start();

require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/Mobily.php';
require_once __DIR__ . '/MobilyQuery.php';
require_once __DIR__ . '/Nay.php';
require_once __DIR__ . '/NayQuery.php';

$conn = DefaultConnection::getDefaultConnection();

if (!isset($_SESSION['edit_id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_SESSION['edit_id'];
$mobil = MobilyQuery::create()->getProduktById($id);
$editErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] === 'update') {
        $mobil->nazov = $_POST['nazov'] ?? '';
        $mobil->model = $_POST['model'] ?? '';
        $mobil->cena = (float)($_POST['cena'] ?? 0.0);
        $mobil->nay_ID = (int)($_POST['nay_ID'] ?? 0);

        try {
            MobilyQuery::create($conn)->saveProdukt($mobil);
            unset($_SESSION['edit_id']);
            echo "<script>alert('Mobil bol úspešne upravený!'); window.location.href='index.php';</script>";
            exit;
        } catch (Exception $e) {
            $editErr = "Chyba: " . $e->getMessage();
        }
    }
}
?>

<?php include __DIR__ . '/header.php'; ?>
<div class="form-container">
    <h2>Upraviť Mobil</h2>

    <?php if (!empty($editErr)): ?>
        <div class="error-box">
            <?= htmlspecialchars($editErr) ?>
        </div>
    <?php endif; ?>

    <form action="editIndex.php" method="POST">
        <input type="hidden" name="action" value="update">

        <div class="form-group">
            <label for="nazov">Názov:</label>
            <input type="text" id="nazov" name="nazov" 
                   value="<?= htmlspecialchars($mobil->nazov) ?>" required>
        </div>
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" 
                   value="<?= htmlspecialchars($mobil->model) ?>" required>
        </div>
        <div class="form-group">
            <label for="cena">Cena (€):</label>
            <input type="number" step="0.01" id="cena" name="cena" 
                   value="<?= $mobil->cena ?>" required>
        </div>
        <div class="form-group">
            <label for="nay_ID">Obchod Nay:</label>
            <select id="nay_ID" name="nay_ID" required>
                <?php foreach (NayQuery::create()->getAllProdukt() as $nay): ?>
                    <option value="<?= $nay->ID ?>" 
                        <?= ($mobil->nay_ID == $nay->ID) ? 'selected' : '' ?>>
                        <?= $nay->mesto ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Uložiť zmeny</button>
    </form>
</div>
    </div>
  </main>
</body>
</html>