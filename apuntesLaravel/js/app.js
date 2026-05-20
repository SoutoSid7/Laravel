const navList = document.getElementById('nav-list');
const pageTitle = document.getElementById('page-title');
const searchBox = document.getElementById('search');
const progressBar = document.getElementById('progress-bar');
const themeBtn = document.getElementById('theme-btn');
const menuToggle = document.getElementById('menu-toggle');
const sidebar = document.querySelector('.sidebar');
const contentArea = document.getElementById('content-area');

let currentId = 'inicio';
const visited = new Set(['inicio']);

function buildNav() {
  let lastSection = '';
  navList.innerHTML = '';

  PAGES.forEach((page) => {
    if (page.section !== lastSection) {
      const li = document.createElement('li');
      li.className = 'nav-section';
      li.textContent = page.section;
      navList.appendChild(li);
      lastSection = page.section;
    }
    const li = document.createElement('li');
    const a = document.createElement('a');
    a.href = '#';
    a.dataset.id = page.id;
    a.dataset.title = page.title.toLowerCase();
    a.textContent = page.title;
    a.addEventListener('click', (e) => {
      e.preventDefault();
      loadPage(page.id);
      sidebar.classList.remove('open');
    });
    li.appendChild(a);
    navList.appendChild(li);
  });
}

function initCopyButtons() {
  document.querySelectorAll('.code-block').forEach((block) => {
    if (block.querySelector('.copy-btn')) return;
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'copy-btn';
    btn.textContent = 'Copiar';
    const pre = block.querySelector('pre');
    if (!pre) return;
    btn.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(pre.innerText);
        btn.textContent = 'Copiado';
        setTimeout(() => { btn.textContent = 'Copiar'; }, 1500);
      } catch (e) {
        btn.textContent = 'Error';
      }
    });
    block.appendChild(btn);
  });
}

function loadPage(id) {
  const page = PAGES.find((p) => p.id === id) || PAGES[0];
  currentId = page.id;
  visited.add(page.id);

  document.querySelectorAll('.page-section').forEach((sec) => {
    sec.classList.toggle('active', sec.id === `page-${page.id}`);
  });

  pageTitle.textContent = page.title;

  document.querySelectorAll('.nav-list a').forEach((a) => {
    a.classList.toggle('active', a.dataset.id === page.id);
  });

  const pct = Math.round((visited.size / PAGES.length) * 100);
  progressBar.style.width = `${pct}%`;

  if (location.protocol !== 'file:') {
    history.replaceState(null, '', `#${page.id}`);
  }

  contentArea.scrollTop = 0;
  initCopyButtons();
}

searchBox?.addEventListener('input', () => {
  const q = searchBox.value.toLowerCase().trim();
  document.querySelectorAll('.nav-list li:not(.nav-section) a').forEach((a) => {
    const match = !q || a.dataset.title.includes(q);
    a.parentElement.style.display = match ? '' : 'none';
  });
});

themeBtn?.addEventListener('click', () => {
  const html = document.documentElement;
  const next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
  html.setAttribute('data-theme', next === 'light' ? 'light' : '');
  localStorage.setItem('laravel-apuntes-theme', next);
  themeBtn.textContent = next === 'light' ? 'Oscuro' : 'Claro';
});

menuToggle?.addEventListener('click', () => sidebar.classList.toggle('open'));

const savedTheme = localStorage.getItem('laravel-apuntes-theme');
if (savedTheme === 'light') {
  document.documentElement.setAttribute('data-theme', 'light');
  if (themeBtn) themeBtn.textContent = 'Oscuro';
}

buildNav();
const hash = location.hash.replace('#', '');
loadPage(PAGES.some((p) => p.id === hash) ? hash : 'inicio');


function initChecklist() {
  const box = document.getElementById('checklist');
  const result = document.getElementById('check-result');
  if (!box) return;
  const checks = [...box.querySelectorAll('input[type="checkbox"]')];
  const saved = JSON.parse(localStorage.getItem('laravel-checklist') || '{}');
  checks.forEach((input) => { input.checked = !!saved[input.dataset.id]; });

  function update() {
    const data = {};
    checks.forEach((input) => { data[input.dataset.id] = input.checked; });
    localStorage.setItem('laravel-checklist', JSON.stringify(data));
    const done = checks.filter((c) => c.checked).length;
    if (result) {
      result.style.display = 'block';
      result.textContent = done === checks.length
        ? 'Perfecto: checklist completo. Ya puedes entregar con más seguridad.'
        : `Llevas ${done}/${checks.length}. Revisa los puntos que faltan antes de entregar.`;
    }
  }

  checks.forEach((input) => input.addEventListener('change', update));
  update();
}

function initQuiz() {
  document.querySelectorAll('[data-quiz] .quiz-question').forEach((q) => {
    const answer = q.dataset.answer;
    const result = q.querySelector('.quiz-result');
    q.querySelectorAll('button[data-option]').forEach((btn) => {
      btn.addEventListener('click', () => {
        q.querySelectorAll('button').forEach((b) => b.classList.remove('correct', 'wrong'));
        if (btn.dataset.option === answer) {
          btn.classList.add('correct');
          if (result) result.textContent = 'Correcto.';
        } else {
          btn.classList.add('wrong');
          const ok = q.querySelector(`button[data-option="${answer}"]`);
          if (ok) ok.classList.add('correct');
          if (result) result.textContent = 'No exactamente. Mira la opción marcada en verde.';
        }
      });
    });
  });
}

// Atajos de teclado: flecha derecha/izquierda para avanzar capítulos.
document.addEventListener('keydown', (e) => {
  if (e.target && ['INPUT', 'TEXTAREA'].includes(e.target.tagName)) return;
  const idx = PAGES.findIndex((p) => p.id === currentId);
  if (e.key === 'ArrowRight' && idx < PAGES.length - 1) loadPage(PAGES[idx + 1].id);
  if (e.key === 'ArrowLeft' && idx > 0) loadPage(PAGES[idx - 1].id);
});

initChecklist();
initQuiz();
