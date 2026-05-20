<?php
$cards = [
    [
        'icon'  => 'ti-clock',
        'title' => 'Evidencia dochádzky',
        'desc'  => 'Dochádzkový systém a riadenie pracovného času na PC alebo mobile.',
    ],
    [
        'icon'  => 'ti-device-mobile',
        'title' => 'Mobilná aplikácia',
        'desc'  => 'Mobilná aplikácia pre registráciu dochádzky a správu aplikácií.',
    ],
    [
        'icon'  => 'ti-shield-lock',
        'title' => 'Správa prístupov',
        'desc'  => 'Centralizovaný systém správy prístupov a bezpečnosti objektov.',
    ],
    [
        'icon'  => 'ti-building',
        'title' => 'Správa návštev',
        'desc'  => 'Digitálny systém evidencie návštevníkov s pokročilými funkciami.',
    ],
    [
        'icon'  => 'ti-tools-kitchen-2',
        'title' => 'Správa stravovania',
        'desc'  => 'Elektronické objednávanie jedál a správa stravovania v organizácii.',
    ],
    [
        'icon'  => 'ti-car',
        'title' => 'Služobné jazdy',
        'desc'  => 'Evidencia služobných ciest od plánu až po vyúčtovanie.',
    ],
];

$pills = [
    'Koniec byrokracie',
    'Zrýchlenie procesov',
    '100% kontrola v čase',
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FPPK</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <link rel="stylesheet" href="test.css" />
</head>
<body>
  <div class="wrapper">

    <div class="hero">
      <p class="hero-badge">Overené praxou</p>
      <h1 class="hero-title">Firemné procesy pod kontrolou</h1>
      <div class="hero-pills">
        <!-- FOREACH -->
        <?php foreach ($pills as $pill): ?>
          <span class="pill">
            <i class="ti ti-circle-check"></i>
            <?= htmlspecialchars($pill) ?>
          </span>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="cards-wrap">
      <div class="cards-grid">
        <?php foreach ($cards as $card): ?>
          <div class="card">
            <i class="ti <?= htmlspecialchars($card['icon']) ?>"></i>
            <p class="card-title"><?= htmlspecialchars($card['title']) ?></p>
            <p class="card-desc"><?= htmlspecialchars($card['desc']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="cta">
      <p>Skoncujte s chaosom<br>a majte vo firme poriadok.</p>
    </div>

  </div>
</body>
</html>