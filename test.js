const data = {
  badge: 'Overené praxou',
  title: 'Firemné procesy pod kontrolou',
  pills: [
    'Koniec byrokracie',
    'Zrýchlenie procesov',
    '100% kontrola v čase',
  ],
  cards: [
    {
      icon: 'ti-clock',
      title: 'Evidencia dochádzky',
      desc: 'Dochádzkový systém a riadenie pracovného času na PC alebo mobile.',
    },
    {
      icon: 'ti-device-mobile',
      title: 'Mobilná aplikácia',
      desc: 'Mobilná aplikácia pre registráciu dochádzky a správu aplikácií.',
    },
    {
      icon: 'ti-shield-lock',
      title: 'Správa prístupov',
      desc: 'Centralizovaný systém správy prístupov a bezpečnosti objektov.',
    },
    {
      icon: 'ti-building',
      title: 'Správa návštev',
      desc: 'Digitálny systém evidencie návštevníkov s pokročilými funkciami.',
    },
    {
      icon: 'ti-tools-kitchen-2',
      title: 'Správa stravovania',
      desc: 'Elektronické objednávanie jedál a správa stravovania v organizácii.',
    },
    {
      icon: 'ti-car',
      title: 'Služobné jazdy',
      desc: 'Evidencia služobných ciest od plánu až po vyúčtovanie.',
    },
  ],
};

function renderPills(pills) {
  return pills
    .map(
      (pill) => `
      <span class="pill">
        <i class="ti ti-circle-check"></i>
        ${pill}
      </span>`
    )
    .join('');
}

function renderCards(cards) {
  return cards
    .map(
      (card) => `
      <div class="card">
        <i class="ti ${card.icon}"></i>
        <p class="card-title">${card.title}</p>
        <p class="card-desc">${card.desc}</p>
      </div>`
    )
    .join('');
}

function render() {
  const app = document.getElementById('app');

  app.innerHTML = `
    <div class="wrapper">

      <div class="hero">
        <p class="hero-badge">${data.badge}</p>
        <h1 class="hero-title">${data.title}</h1>
        <div class="hero-pills">
          ${renderPills(data.pills)}
        </div>
      </div>

      <div class="cards-wrap">
        <div class="cards-grid">
          ${renderCards(data.cards)}
        </div>
      </div>

      <div class="cta">
        <p>Skoncujte s chaosom<br>a majte vo firme poriadok.</p>
      </div>

    </div>
  `;
}

document.addEventListener('DOMContentLoaded', render);