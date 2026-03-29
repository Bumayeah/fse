document.addEventListener('DOMContentLoaded', function () {
  var btn      = document.getElementById('fse-mobile-menu-btn');
  var panel    = document.getElementById('fse-mobile-menu');
  var backdrop = document.getElementById('fse-mobile-menu-backdrop');

  if (!btn || !panel || !backdrop) return;

  // Move out of the header stacking context so `fixed` positions relative to viewport
  document.body.appendChild(backdrop);
  document.body.appendChild(panel);

  // Detect WordPress admin bar height so panel appears below it
  var adminBar   = document.getElementById('wpadminbar');
  var adminBarH  = adminBar ? adminBar.offsetHeight : 0;
  var panelTop   = adminBarH + 8;

  Object.assign(backdrop.style, {
    position:       'fixed',
    top:            adminBarH + 'px',
    left:           '0',
    right:          '0',
    bottom:         '0',
    zIndex:         '100000',
    background:     'rgba(39,39,42,0.4)',
    backdropFilter: 'blur(4px)',
  });

  var isDark = document.documentElement.classList.contains('dark');
  Object.assign(panel.style, {
    position:        'fixed',
    top:             panelTop + 'px',
    left:            '16px',
    right:           '16px',
    zIndex:          '100001',
    borderRadius:    '1.5rem',
    padding:         '2rem',
    backgroundColor: isDark ? '#18181b' : '#ffffff',
    boxShadow:       '0 0 0 1px rgba(0,0,0,0.05)',
  });

  // Re-query close button after panel is moved to body
  var close = document.getElementById('fse-mobile-menu-close');

  function openMenu() {
    backdrop.style.display = 'block';
    panel.style.display    = 'block';
    btn.setAttribute('aria-expanded', 'true');
  }

  function closeMenu() {
    backdrop.style.display = 'none';
    panel.style.display    = 'none';
    btn.setAttribute('aria-expanded', 'false');
  }

  // Start hidden
  backdrop.style.display = 'none';
  panel.style.display    = 'none';

  btn.addEventListener('click', openMenu);
  if (close) close.addEventListener('click', closeMenu);
  backdrop.addEventListener('click', closeMenu);
});
